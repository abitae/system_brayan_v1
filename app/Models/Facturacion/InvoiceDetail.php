<?php

namespace App\Models\Facturacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'invoice_id',
        'tipAfeIgv',
        'codProducto',
        'unidad',
        'descripcion',
        'cantidad',
        'mtoValorUnitario',
        'mtoValorVenta',
        'mtoBaseIgv',
        'porcentajeIgv',
        'igv',
        'totalImpuestos',
        'mtoPrecioUnitario',
    ];
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
