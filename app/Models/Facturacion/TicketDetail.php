<?php

namespace App\Models\Facturacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'ticket_id',
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
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
