<?php

namespace App\Services;

use App\Models\Caja\Caja;
use App\Models\Caja\EntryCaja;
use App\Models\Caja\ExitCaja;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class CajaService
{
    public function activeFor(User $user): ?Caja
    {
        return Caja::where('user_id', $user->id)
            ->where('isActive', true)
            ->latest()
            ->first();
    }

    public function entry(int $cajaId, float $monto, string $description, string $metodoPago, string $tipo): EntryCaja
    {
        return EntryCaja::create([
            'caja_id' => $cajaId,
            'monto_entry' => $monto,
            'description' => $description,
            'metodo_pago' => $metodoPago,
            'tipo_entry' => $tipo,
        ]);
    }

    public function entryEntrega(int $cajaId, float $monto, string $metodoPago, string $tipoComprobante, string $code): EntryCaja
    {
        return EntryCaja::updateOrCreate(
            [
                'caja_id' => $cajaId,
                'description' => 'ENTREGA '.$tipoComprobante,
                'tipo_entry' => $code,
            ],
            [
                'monto_entry' => $monto,
                'metodo_pago' => $metodoPago,
            ]
        );
    }

    public function exit(int $cajaId, float $monto, string $description, string $metodoPago, string $tipo): ExitCaja
    {
        return ExitCaja::create([
            'caja_id' => $cajaId,
            'monto_exit' => $monto,
            'description' => $description,
            'metodo_pago' => $metodoPago,
            'tipo_exit' => $tipo,
        ]);
    }

    public function open(User $user, float $montoApertura): Caja
    {
        if ($this->activeFor($user)) {
            throw ValidationException::withMessages([
                'caja' => 'Ya tiene una caja abierta.',
            ]);
        }

        return Caja::create([
            'user_id' => $user->id,
            'monto_apertura' => $montoApertura,
            'monto_cierre' => $montoApertura,
            'isActive' => true,
        ]);
    }

    public function efectivoActual(Caja $caja): float
    {
        $caja->loadMissing(['entries', 'exits']);

        return (float) $caja->monto_apertura
            + (float) $caja->entries->where('metodo_pago', 'Efectivo')->sum('monto_entry')
            - (float) $caja->exits->where('metodo_pago', 'Efectivo')->sum('monto_exit');
    }

    public function close(Caja $caja, float $montoCierre): Caja
    {
        $esperado = $this->efectivoActual($caja);

        if (round($montoCierre, 2) !== round($esperado, 2)) {
            throw ValidationException::withMessages([
                'monto_cierre' => 'El monto de cierre no coincide con el saldo en efectivo.',
            ]);
        }

        $caja->update([
            'monto_cierre' => $montoCierre,
            'isActive' => false,
        ]);

        return $caja->fresh();
    }
}
