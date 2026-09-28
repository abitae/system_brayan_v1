<?php

namespace App\Http\Resources;

use App\Models\Package\Encomienda;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Encomienda */
class EncomiendaResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'estado_encomienda' => $this->estado_encomienda,
            'estado_pago' => $this->estado_pago,
            'estado_credito' => $this->estado_credito,
            'tipo_pago' => $this->tipo_pago,
            'metodo_pago' => $this->metodo_pago,
            'tipo_comprobante' => $this->tipo_comprobante,
            'monto' => $this->monto,
            'monto_descuento' => $this->monto_descuento,
            'isHome' => (bool) $this->isHome,
            'fecha_creacion' => $this->fecha_creacion,
            'fecha_envio' => $this->fecha_envio,
            'fecha_recepcion' => $this->fecha_recepcion,
            'fecha_entrega' => $this->fecha_entrega,
            'direccion' => $this->isHome ? $this->destinatario?->address : $this->llegada_direccion,
            'remitente' => $this->whenLoaded('remitente', fn () => [
                'id' => $this->remitente->id,
                'code' => $this->remitente->code,
                'name' => $this->remitente->name,
            ]),
            'destinatario' => $this->whenLoaded('destinatario', fn () => [
                'id' => $this->destinatario->id,
                'code' => $this->destinatario->code,
                'name' => $this->destinatario->name,
                'address' => $this->destinatario->address,
                'phone' => $this->destinatario->phone,
            ]),
            'facturacion' => $this->whenLoaded('facturacion', fn () => [
                'id' => $this->facturacion->id,
                'code' => $this->facturacion->code,
                'name' => $this->facturacion->name,
                'type_code' => $this->facturacion->type_code,
            ]),
            'sucursal_origen' => $this->whenLoaded('sucursal_remitente', fn () => $this->sucursal_remitente->name),
            'sucursal_destino' => $this->whenLoaded('sucursal_destinatario', fn () => $this->sucursal_destinatario->name),
            'repartidor' => $this->whenLoaded('repartidor', fn () => $this->repartidor ? [
                'id' => $this->repartidor->id,
                'name' => $this->repartidor->name,
            ] : null),
            'cobro' => $this->repartidor_user_id
                ? ($this->repartidor?->name ?? 'Repartidor')
                : 'Cobro en agencia',
            'paquetes' => $this->whenLoaded('paquetes', fn () => $this->paquetes->map(fn ($paquete) => [
                'id' => $paquete->id,
                'description' => $paquete->description,
                'cantidad' => $paquete->cantidad,
                'peso' => $paquete->peso,
                'sub_total' => $paquete->sub_total,
            ])),
        ];
    }
}
