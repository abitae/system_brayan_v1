<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Caja\Caja;
use App\Models\Configuration\Sucursal;
use App\Models\Configuration\Transportista;
use App\Models\Package\Customer;
use App\Models\Package\Encomienda;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'sucursal_id',
        'customer_id',
        'transportista_id',
        'isActive',
        'password',
        'isPin'
    ];
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function transportista()
    {
        return $this->belongsTo(Transportista::class);
    }
    public function cajas()
    {
        return $this->hasMany(Caja::class);
    }
    public function reparto()
    {
        return $this->hasMany(Encomienda::class, 'repartidor_user_id');
    }
    public function encomiendas()
    {
        return $this->hasMany(Encomienda::class);
    }
    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
