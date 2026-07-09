<?php

namespace App\Services\Frontend;

use App\Models\Package\Encomienda;
use Carbon\Carbon;

class TrackingService
{
    /**
     * @return array<string, mixed>|null
     */
    public function findByCodeAndDocument(string $code, string $document): ?array
    {
        $code = trim($code);
        $document = trim($document);

        $encomienda = Encomienda::query()
            ->where('code', $code)
            ->where('isActive', true)
            ->where(function ($query) use ($document) {
                $query->whereHas('remitente', fn ($q) => $q->where('code', $document))
                    ->orWhereHas('destinatario', fn ($q) => $q->where('code', $document));
            })
            ->with(['sucursal_remitente', 'sucursal_destinatario', 'destinatario'])
            ->first();

        if ($encomienda === null) {
            return null;
        }

        return $this->toPayload($encomienda);
    }

    /**
     * @return array<string, mixed>
     */
    private function toPayload(Encomienda $encomienda): array
    {
        $origen = $encomienda->sucursal_remitente;
        $destino = $encomienda->sucursal_destinatario;
        $isHome = (bool) $encomienda->isHome;

        return [
            'code' => $encomienda->code,
            'estado_encomienda' => $encomienda->estado_encomienda,
            'name_origen' => $origen?->name ?? '',
            'lugar_origen' => $this->formatSucursalLocation($origen),
            'name_destino' => $destino?->name ?? '',
            'lugar_destino' => $this->formatSucursalLocation($destino),
            'direccion_envio' => $isHome ? ($encomienda->destinatario?->address ?: null) : null,
            'isHome' => $isHome,
            'fecha_creacion' => $this->formatDate($encomienda->fecha_creacion),
            'fecha_envio' => $this->formatDate($encomienda->fecha_envio),
            'fecha_recepcion' => $this->formatDate($encomienda->fecha_recepcion),
            'fecha_entrega' => $this->formatDate($encomienda->fecha_entrega),
            'fecha_retorno' => $this->formatDate($encomienda->fecha_retorno),
        ];
    }

    private function formatSucursalLocation(?object $sucursal): string
    {
        if ($sucursal === null) {
            return '';
        }

        $address = trim((string) ($sucursal->address ?? ''));
        if ($address !== '') {
            return $address;
        }

        $parts = array_filter([
            $sucursal->distrito ?? null,
            $sucursal->provincia ?? null,
            $sucursal->departamento ?? null,
        ]);

        return implode(', ', $parts);
    }

    private function formatDate(mixed $value): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        if ($value instanceof Carbon) {
            return $value->format('Y-m-d H:i:s');
        }

        try {
            return Carbon::parse($value)->format('Y-m-d H:i:s');
        } catch (\Throwable) {
            return null;
        }
    }
}
