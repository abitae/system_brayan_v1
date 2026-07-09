<?php

namespace App\Models\Package;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paquete extends Model
{
    use HasFactory;
    protected $fillable = [
        'encomienda_id',
        'cantidad',
        'und_medida',
        'description',
        'peso',
        'amount',
        'sub_total'
    ];
    public function encomienda()
    {
        return $this->belongsTo(Encomienda::class);
    }
}
