<?php

namespace App\Models\Caja;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntryCaja extends Model
{
    use HasFactory;
    protected $fillable = [
        'caja_id',
        'monto_entry',
        'description',
        'metodo_pago',
        'tipo_entry',
    ];
    public function caja()
    {
        return $this->belongsTo(Caja::class);
    }
}
