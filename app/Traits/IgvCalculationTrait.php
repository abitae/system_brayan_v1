<?php

namespace App\Traits;

trait IgvCalculationTrait
{
    protected function calcIgvMonto(float $montoIncIGV, float $factor = 0.18): array
    {
        $base = round($montoIncIGV / (1 + $factor), 2);
        $igv = round($base * $factor, 2);

        return [
            'base' => $base,
            'igv' => $igv,
            'total' => round($base + $igv, 2),
        ];
    }

    protected function calcIgvLinea(float $montoUnitarioIncIGV, float $cantidad, float $factor = 0.18): array
    {
        $split = $this->calcIgvMonto($montoUnitarioIncIGV * $cantidad, $factor);

        return [
            'mtoValorUnitario' => $cantidad > 0 ? round($split['base'] / $cantidad, 4) : 0,
            'mtoValorVenta' => $split['base'],
            'mtoBaseIgv' => $split['base'],
            'igv' => $split['igv'],
            'totalImpuestos' => $split['igv'],
            'mtoPrecioUnitario' => $montoUnitarioIncIGV,
        ];
    }
}
