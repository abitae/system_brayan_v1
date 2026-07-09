<?php

namespace App\Models\Facturacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoteDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'note_id',
        'codProducto',
        'unidad',
        'cantidad',
        'descripcion',
        'mtoBaseIgv',
        'porcentajeIgv',
        'igv',
        'tipAfeIgv',
        'totalImpuestos',
        'mtoValorVenta',
        'mtoValorUnitario',
        'mtoPrecioUnitario',
    ];
    public function notes()
    {
        return $this->hasMany(Note::class);
    }
}
