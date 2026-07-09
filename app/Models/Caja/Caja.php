<?php

namespace App\Models\Caja;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'monto_apertura',
        'monto_cierre',
        'isActive',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function entries()
    {
        return $this->hasMany(EntryCaja::class);
    }
    public function exits()
    {
        return $this->hasMany(ExitCaja::class);
    }
}
