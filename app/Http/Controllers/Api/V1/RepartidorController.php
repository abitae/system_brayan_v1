<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CajaResource;
use App\Http\Resources\EncomiendaResource;
use App\Models\Package\Encomienda;
use App\Services\CajaService;
use App\Services\EntregaDomicilioService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class RepartidorController extends Controller
{
    public function __construct(
        private readonly CajaService $cajaService,
        private readonly EntregaDomicilioService $entregaService,
    ) {}

    public function caja(Request $request): JsonResponse
    {
        $caja = $this->cajaService->activeFor($request->user());

        return response()->json([
            'data' => $caja ? (new CajaResource($caja))->resolve() : null,
        ]);
    }

    public function abrirCaja(Request $request): JsonResponse
    {
        $data = $request->validate([
            'monto_apertura' => ['required', 'numeric', 'min:0'],
        ]);

        $caja = $this->cajaService->open($request->user(), (float) $data['monto_apertura']);

        return response()->json([
            'data' => (new CajaResource($caja))->resolve(),
        ], 201);
    }

    public function cerrarCaja(Request $request): JsonResponse
    {
        $data = $request->validate([
            'monto_cierre' => ['required', 'numeric', 'min:0'],
        ]);

        $caja = $this->cajaService->activeFor($request->user());
        abort_unless($caja, 422, 'No tiene una caja abierta.');

        return response()->json([
            'data' => (new CajaResource($this->cajaService->close($caja, (float) $data['monto_cierre'])))->resolve(),
        ]);
    }

    public function encomiendas(Request $request): AnonymousResourceCollection
    {
        $encomiendas = Encomienda::query()
            ->with(['remitente', 'destinatario', 'facturacion', 'paquetes', 'sucursal_destinatario'])
            ->where('repartidor_user_id', $request->user()->id)
            ->where('sucursal_dest_id', $request->user()->sucursal_id)
            ->where('isHome', true)
            ->where('isReturn', false)
            ->where('estado_encomienda', 'RECIBIDO')
            ->latest('fecha_recepcion')
            ->paginate(20);

        return EncomiendaResource::collection($encomiendas);
    }

    public function show(Request $request, Encomienda $encomienda): EncomiendaResource
    {
        abort_unless(
            (int) $encomienda->repartidor_user_id === (int) $request->user()->id
            && (int) $encomienda->sucursal_dest_id === (int) $request->user()->sucursal_id,
            403
        );

        $encomienda->load(['remitente', 'destinatario', 'facturacion', 'paquetes', 'sucursal_destinatario']);

        return new EncomiendaResource($encomienda);
    }

    public function entregar(Request $request, Encomienda $encomienda): EncomiendaResource
    {
        $data = $request->validate([
            'documento' => ['required', 'string'],
            'pin' => ['required', 'integer'],
            'paquetes_confirmados' => ['required', 'array', 'min:1'],
            'paquetes_confirmados.*' => ['integer'],
            'tipo_pago' => ['nullable', 'in:Contado'],
            'metodo_pago' => ['nullable', 'in:Efectivo,Yape,Transferencia,Deposito'],
            'monto_descuento' => ['nullable', 'numeric', 'min:0'],
        ]);

        $entregada = $this->entregaService->entregar(
            $request->user(),
            $encomienda,
            $data['documento'],
            (int) $data['pin'],
            $data['paquetes_confirmados'],
            null,
            $data['tipo_pago'] ?? null,
            $data['metodo_pago'] ?? null,
            isset($data['monto_descuento']) ? (float) $data['monto_descuento'] : null,
        );

        return new EncomiendaResource($entregada);
    }
}
