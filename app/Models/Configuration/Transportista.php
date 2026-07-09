<?php

namespace App\Models\Configuration;

use App\Models\Package\Encomienda;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transportista extends Model
{
    use HasFactory;
    protected $fillable = [
        'type_code',
        'licencia',
        'dni',
        'name',
        'tipo',
        'isActive',
    ];
    public function encomiendas()
    {
        return $this->hasMany(Encomienda::class);
    }
    public function sucursal_configurations()
    {
        return $this->hasMany(SucursalConfiguration::class);
    }
}
