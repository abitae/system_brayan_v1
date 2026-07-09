<?php

namespace App\Models\Package;

use App\Models\Configuration\Sucursal;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manifiesto extends Model
{
    use HasFactory;
    protected $fillable = [
        'sucursal_id',
        'sucursal_destino_id',
        'ids',
    ];
    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'sucursal_id');
    }
    public function destino()
    {
        return $this->belongsTo(Sucursal::class, 'sucursal_destino_id');
    }
}
