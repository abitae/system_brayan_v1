<?php

namespace App\Traits;

trait IgvCalculationTrait
{
    protected function calcIgvMonto(float $montoIncIGV, float $factor = 0.18): array
    {
        $total = round($montoIncIGV, 2);
        $base = round($total / (1 + $factor), 2);
        $igv = round($total - $base, 2);

        return [
            'base' => $base,
            'igv' => $igv,
            'total' => $total,
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
