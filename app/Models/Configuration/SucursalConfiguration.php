<?php

namespace App\Models\Configuration;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SucursalConfiguration extends Model
{
    use HasFactory;
    protected $fillable = [
        'sucursal_id',
        'sucursal_destino_id',
        'vehiculo_id',
        'transportista_id',
        'date_config',
        'isActive'
    ];
    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'sucursal_id');
    }
    public function destino()
    {
        return $this->belongsTo(Sucursal::class, 'sucursal_destino_id');
    }
    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class);
    }
    public function transportista()
    {
        return $this->belongsTo(Transportista::class);
    }
}
