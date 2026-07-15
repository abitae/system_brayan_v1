<?php

namespace App\Models\Configuration;

use Illuminate\Database\Eloquent\Model;

class SubscriptionNotice extends Model
{
    protected $fillable = [
        'fecha_vencimiento',
        'is_activo',
        'is_close',
    ];

    protected function casts(): array
    {
        return [
            'fecha_vencimiento' => 'date',
            'is_activo' => 'boolean',
            'is_close' => 'boolean',
        ];
    }
}
