<?php
namespace App\Models\Package;

use App\Models\Facturacion\Despatche;
use App\Models\Facturacion\Invoice;
use App\Models\Facturacion\Note;
use App\Models\Facturacion\Ticket;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = [
        'type_code',
        'code',
        'name',
        'phone',
        'email',
        'address',
        'ubigeo',
        'isActive',
    ];
    public function encomiendas_remitente()
    {
        return $this->hasMany(Encomienda::class, 'customer_id', 'id');
    }
    public function encomiendas_destinatario()
    {
        return $this->hasMany(Encomienda::class, 'customer_dest_id', 'id');
    }
    public function encomiendas_facturacion()
    {
        return $this->hasMany(Encomienda::class, 'customer_fact_id', 'id');
    }
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function despach_flete()
    {
        return $this->hasMany(Despatche::class, 'flete_id', 'id');
    }
    public function despach_remitente()
    {
        return $this->hasMany(Despatche::class, 'remitente_id', 'id');
    }
    public function despach_destinatario()
    {
        return $this->hasMany(Despatche::class, 'destinatario_id', 'id');
    }
    public function notes()
    {
        return $this->hasMany(Note::class);
    }

}
