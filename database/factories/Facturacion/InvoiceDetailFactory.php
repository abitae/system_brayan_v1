<?php

namespace Database\Factories\Facturacion;

use App\Models\Facturacion\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Facturacion\InvoiceDetail>
 */
class InvoiceDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'invoice_id' => $this->faker->randomElement(Invoice::pluck('id')->toArray()),
            'tipAfeIgv' => $this->faker->randomElement(['10', '20', '30']),
            'codProducto' => $this->faker->regexify('[A-Z0-9]{10}'),
            'unidad' => $this->faker->randomElement(['NIU', 'KG', 'LTR']),
            'descripcion' => $this->faker->sentence,
            'cantidad' => $this->faker->numberBetween(1, 100),
            'mtoValorUnitario' => $this->faker->randomFloat(2, 10, 1000),
            'mtoValorVenta' => $this->faker->randomFloat(2, 10, 1000),
            'mtoBaseIgv' => $this->faker->randomFloat(2, 10, 1000),
            'porcentajeIgv' => $this->faker->randomFloat(2, 0, 18),
            'igv' => $this->faker->randomFloat(2, 0, 180),
            'totalImpuestos' => $this->faker->randomFloat(2, 0, 180),
            'mtoPrecioUnitario' => $this->faker->randomFloat(2, 10, 1000),
        ];
    }
}
