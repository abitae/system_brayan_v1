<?php

namespace App\Models\Frontend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reclamacion extends Model
{
    use HasFactory;
    protected $fillable = [
        'reclamo_nombre',
        'reclamo_documento',
        'reclamo_telefono',
        'reclamo_email',
        'reclamo_direccion',
        'reclamo_tipo',
        'reclamo_producto',
        'reclamo_monto',
        'reclamo_descripcion',
        'reclamo_politicas',
        'isActive',
    ];
}
