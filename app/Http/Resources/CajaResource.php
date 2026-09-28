<?php

namespace App\Http\Resources;

use App\Models\Caja\Caja;
use App\Services\CajaService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Caja */
class CajaResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $this->loadMissing(['entries', 'exits', 'user']);

        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'usuario' => $this->user?->name,
            'monto_apertura' => $this->monto_apertura,
            'monto_cierre' => $this->monto_cierre,
            'isActive' => (bool) $this->isActive,
            'efectivo_actual' => app(CajaService::class)->efectivoActual($this->resource),
            'entries' => $this->entries->map(fn ($entry) => [
                'id' => $entry->id,
                'monto' => $entry->monto_entry,
                'description' => $entry->description,
                'metodo_pago' => $entry->metodo_pago,
                'tipo' => $entry->tipo_entry,
                'created_at' => $entry->created_at,
            ]),
            'exits' => $this->exits->map(fn ($exit) => [
                'id' => $exit->id,
                'monto' => $exit->monto_exit,
                'description' => $exit->description,
                'metodo_pago' => $exit->metodo_pago,
                'tipo' => $exit->tipo_exit,
                'created_at' => $exit->created_at,
            ]),
        ];
    }
}
