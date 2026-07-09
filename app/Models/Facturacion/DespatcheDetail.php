<?php

namespace App\Models\Facturacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DespatcheDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'despatche_id',
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
    public function despache()
    {
        return $this->belongsTo(Despatche::class);
    }
}
