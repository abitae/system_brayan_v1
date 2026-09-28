<?php

namespace App\Http\Resources;

use App\Models\Facturacion\Invoice;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Invoice */
class InvoiceResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'tipoDoc' => $this->tipoDoc,
            'tipo' => $this->tipoDoc === '01' ? 'FACTURA' : 'BOLETA',
            'serie' => $this->serie,
            'correlativo' => $this->correlativo,
            'fechaEmision' => $this->fechaEmision,
            'mtoImpVenta' => $this->mtoImpVenta,
            'estado' => $this->estado,
            'encomienda_id' => $this->encomienda_id,
        ];
    }
}
