<?php

namespace App\Services;

use App\Models\Package\Encomienda;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class AsignacionRepartidorService
{
    public function asignar(User $admin, Encomienda $encomienda, User $repartidor): Encomienda
    {
        if (! $admin->hasRole('Admin sucursal') || (int) $encomienda->sucursal_dest_id !== (int) $admin->sucursal_id) {
            throw ValidationException::withMessages([
                'encomienda' => 'La encomienda no pertenece a su sucursal.',
            ]);
        }

        if ($encomienda->estado_encomienda !== 'RECIBIDO' || ! $encomienda->isHome || $encomienda->isReturn) {
            throw ValidationException::withMessages([
                'encomienda' => 'Solo se asignan encomiendas a domicilio recibidas y pendientes.',
            ]);
        }

        if (
            ! $repartidor->hasRole('Repartidor')
            || ! $repartidor->isActive
            || (int) $repartidor->sucursal_id !== (int) $admin->sucursal_id
            || $repartidor->transportista_id === null
        ) {
            throw ValidationException::withMessages([
                'repartidor_user_id' => 'El repartidor debe estar activo, ligado a un transportista y pertenecer a su sucursal.',
            ]);
        }

        $encomienda->repartidor_user_id = $repartidor->id;
        $encomienda->save();

        return $encomienda->fresh('repartidor');
    }
}
