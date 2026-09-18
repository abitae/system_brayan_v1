<?php

namespace Tests\Unit;

use App\Traits\IgvCalculationTrait;
use PHPUnit\Framework\TestCase;

class IgvCalculationTest extends TestCase
{
    private function calculator(): object
    {
        return new class
        {
            use IgvCalculationTrait;

            public function split(float $monto): array
            {
                return $this->calcIgvMonto($monto);
            }
        };
    }

    public function test_total_incluye_igv_se_conserva_al_desglosar(): void
    {
        $split = $this->calculator()->split(600);

        $this->assertEqualsWithDelta(508.47, $split['base'], 0.001);
        $this->assertEqualsWithDelta(91.53, $split['igv'], 0.001);
        $this->assertEqualsWithDelta(600.00, $split['total'], 0.001);
        $this->assertEqualsWithDelta(600.00, round($split['base'] + $split['igv'], 2), 0.001);
    }

    public function test_montos_con_redondeo_no_pierden_un_centimo(): void
    {
        foreach ([10, 50, 100, 118, 400, 599.99, 1000] as $monto) {
            $split = $this->calculator()->split($monto);

            $this->assertEqualsWithDelta(
                round($monto, 2),
                round($split['base'] + $split['igv'], 2),
                0.001,
                "Falló para el monto {$monto}"
            );
        }
    }
}
