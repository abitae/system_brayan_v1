<?php

namespace App\Models\Configuration;

use App\Models\Facturacion\Invoice;
use App\Models\Facturacion\Note;
use App\Models\Package\Encomienda;
use App\Models\Package\Manifiesto;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'codeSunat',
        'igv',
        'serieFactura',
        'serieBoleta',
        'serieGuiaRemision',
        'serieNotaCreditoFactura',
        'serieNotaCreditoBoleta',
        'serieNotaDebitoFactura',
        'serieNotaDebitoBoleta',
        'color',
        'name',
        'departamento',
        'provincia',
        'distrito',
        'urbanizacion',
        'address',
        'phone',
        'email',
        'ubigeo',
        'isActive',
    ];
    public function encomiendas_remitente()
    {
        return $this->hasMany(Encomienda::class, 'customer_id','id');
    }
    public function encomiendas_destinatario()
    {
        return $this->hasMany(Encomienda::class, 'customer_dest_id','id');
    }
    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function manifiestos()
    {
        return $this->hasMany(Manifiesto::class);
    }
    public function sucursal_configurations()
    {
        return $this->hasMany(SucursalConfiguration::class);
    }
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
    public function notes()
    {
        return $this->hasMany(Note::class);
    }
}
