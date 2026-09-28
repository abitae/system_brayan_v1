<?php

namespace App\Services;

use App\Models\Package\Customer;
use App\Models\Package\Encomienda;
use App\Models\User;
use App\Traits\InvoiceTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class EntregaDomicilioService
{
    use InvoiceTrait;

    public function __construct(private readonly CajaService $cajaService) {}

    /**
     * @param  array<int, int>  $paquetesConfirmados
     */
    public function entregar(
        User $repartidor,
        Encomienda $encomienda,
        string $documento,
        int $pin,
        array $paquetesConfirmados,
        ?Customer $facturacion = null,
        ?string $tipoPago = null,
        ?string $metodoPago = null,
        ?float $montoDescuento = null,
    ): Encomienda {
        $this->assertChecklist($encomienda, $paquetesConfirmados);

        $encomienda->loadMissing('destinatario');

        if ($encomienda->destinatario->code !== $documento || (int) $encomienda->pin !== $pin) {
            throw ValidationException::withMessages([
                'pin' => 'El documento o el PIN no coinciden con el destinatario.',
            ]);
        }

        $caja = $this->cajaService->activeFor($repartidor);
        if (! $caja) {
            throw ValidationException::withMessages([
                'caja' => 'Debe abrir caja para entregar encomiendas.',
            ]);
        }

        return DB::transaction(function () use ($repartidor, $encomienda, $facturacion, $tipoPago, $metodoPago, $montoDescuento) {
            $locked = $this->bloquear($encomienda);
            $this->assertAsignada($repartidor, $locked);
            $this->assertPendiente($locked);

            if ($locked->estado_pago === 'PAGADO') {
                $locked->fecha_entrega = Carbon::now();
                $locked->estado_encomienda = 'ENTREGADO';
                $locked->save();

                return $locked->fresh(['paquetes', 'remitente', 'destinatario', 'facturacion']);
            }

            $this->aplicarCobro(
                $repartidor,
                $locked,
                $facturacion ?? $locked->facturacion,
                $locked->tipo_comprobante,
                $tipoPago ?? 'Contado',
                $metodoPago ?? ($locked->metodo_pago ?: 'Efectivo'),
                $montoDescuento,
            );

            return $locked->fresh(['paquetes', 'remitente', 'destinatario', 'facturacion']);
        });
    }

    public function cobrar(
        User $user,
        Encomienda $encomienda,
        Customer $facturacion,
        string $tipoComprobante,
        string $tipoPago,
        string $metodoPago,
        ?float $montoDescuento = null,
    ): void {
        DB::transaction(function () use ($user, $encomienda, $facturacion, $tipoComprobante, $tipoPago, $metodoPago, $montoDescuento) {
            $locked = $this->bloquear($encomienda);
            $this->assertSinRepartidor($locked);
            $this->assertPendiente($locked);

            $this->aplicarCobro($user, $locked, $facturacion, $tipoComprobante, $tipoPago, $metodoPago, $montoDescuento);
        });
    }

    public function marcarEntregadaEnOficina(Encomienda $encomienda): void
    {
        DB::transaction(function () use ($encomienda) {
            $locked = $this->bloquear($encomienda);
            $this->assertSinRepartidor($locked);
            $this->assertPendiente($locked);

            $locked->fecha_entrega = Carbon::now();
            $locked->estado_encomienda = 'ENTREGADO';
            $locked->save();
        });
    }

    private function aplicarCobro(
        User $user,
        Encomienda $encomienda,
        Customer $facturacion,
        string $tipoComprobante,
        string $tipoPago,
        string $metodoPago,
        ?float $montoDescuento = null,
    ): void {
        if ($tipoComprobante === 'TICKET') {
            $facturacion = $encomienda->facturacion;
            if ($montoDescuento !== null && $montoDescuento > 0 && $montoDescuento < (float) $encomienda->monto) {
                $this->aplicarDescuento($user, $encomienda, $montoDescuento, $metodoPago, $tipoComprobante);
            }
        }

        if ($tipoComprobante === 'FACTURA' && (string) $facturacion->type_code !== '6') {
            throw ValidationException::withMessages([
                'tipo_comprobante' => 'El cliente de facturación debe ser un RUC.',
            ]);
        }

        $encomienda->customer_fact_id = $facturacion->id;
        $encomienda->tipo_comprobante = $tipoComprobante;
        $encomienda->tipo_pago = $tipoPago;
        $encomienda->metodo_pago = $metodoPago;
        $encomienda->estado_encomienda = 'ENTREGADO';
        $encomienda->fecha_entrega = Carbon::now();

        if ($tipoPago === 'Contado') {
            $encomienda->estado_pago = 'PAGADO';
            $encomienda->estado_credito = 'Cancelado';
        }

        $encomienda->save();

        if ($tipoPago === 'Contado') {
            $caja = $this->cajaService->activeFor($user);
            if (! $caja) {
                throw ValidationException::withMessages([
                    'caja' => 'Debe abrir caja para entregar encomiendas.',
                ]);
            }

            $this->cajaService->entryEntrega(
                $caja->id,
                (float) $encomienda->monto,
                $metodoPago,
                $encomienda->tipo_comprobante,
                $encomienda->code,
            );
        }

        if ($tipoComprobante !== 'TICKET') {
            $this->setInvoice($encomienda, $tipoComprobante);
        }
    }

    private function aplicarDescuento(User $user, Encomienda $encomienda, float $montoDescuento, string $metodoPago, string $tipoComprobante): void
    {
        $encomienda->monto_descuento = $montoDescuento;
        $encomienda->save();

        if ($encomienda->ticket) {
            $encomienda->ticket->monto_descuento = $montoDescuento;
            $encomienda->ticket->save();
        }

        $caja = $this->cajaService->activeFor($user);
        if (! $caja) {
            throw ValidationException::withMessages([
                'caja' => 'Debe abrir caja para entregar encomiendas.',
            ]);
        }

        $this->cajaService->exit(
            $caja->id,
            $montoDescuento,
            ' DESCUENTO '.$tipoComprobante,
            $metodoPago,
            $encomienda->code,
        );
    }

    /**
     * @param  array<int, int>  $paquetesConfirmados
     */
    private function assertChecklist(Encomienda $encomienda, array $paquetesConfirmados): void
    {
        $esperados = $encomienda->paquetes()->pluck('id')->map(fn ($id) => (int) $id)->sort()->values()->all();
        $marcados = collect($paquetesConfirmados)->map(fn ($id) => (int) $id)->unique()->sort()->values()->all();

        if ($esperados === [] || $esperados !== $marcados) {
            throw ValidationException::withMessages([
                'paquetes_confirmados' => 'Debe marcar todos los bultos antes de confirmar la entrega.',
            ]);
        }
    }

    private function bloquear(Encomienda $encomienda): Encomienda
    {
        return Encomienda::query()->whereKey($encomienda->id)->lockForUpdate()->firstOrFail();
    }

    private function assertPendiente(Encomienda $encomienda): void
    {
        if ($encomienda->estado_encomienda !== 'RECIBIDO') {
            throw ValidationException::withMessages([
                'encomienda' => 'La encomienda ya fue entregada o no está disponible para entrega.',
            ]);
        }
    }

    private function assertSinRepartidor(Encomienda $encomienda): void
    {
        if ($encomienda->repartidor_user_id) {
            throw ValidationException::withMessages([
                'encomienda' => 'Esta encomienda está asignada a un repartidor.',
            ]);
        }
    }

    private function assertAsignada(User $repartidor, Encomienda $encomienda): void
    {
        if (
            (int) $encomienda->repartidor_user_id !== (int) $repartidor->id
            || (int) $encomienda->sucursal_dest_id !== (int) $repartidor->sucursal_id
            || ! $encomienda->isHome
            || $encomienda->isReturn
        ) {
            throw ValidationException::withMessages([
                'encomienda' => 'La encomienda no está asignada a este repartidor.',
            ]);
        }
    }
}
