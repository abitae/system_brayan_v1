<?php

namespace App\Models\Configuration;

use App\Models\Facturacion\Despatche;
use App\Models\Facturacion\Invoice;
use App\Models\Facturacion\Note;
use App\Models\Facturacion\Ticket;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $fillable = [
        'ruc',
        'razonSocial',
        'address',
        'email',
        'telephone',
        'ubigeo',
        'ctaBanco',
        'pin',
        'nroMtc',
        'logo_path',
        'sol_user',
        'sol_pass',
        'cert_path',
        'client_id',
        'client_secret',
        'production',
    ];
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
    public function despatchs()
    {
        return $this->hasMany(Despatche::class);
    }
    public function notes()
    {
        return $this->hasMany(Note::class);
    }
}
