<?php

namespace Database\Factories\Facturacion;

use App\Models\Configuration\Company;
use App\Models\Package\Customer;
use App\Models\Package\Encomienda;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Facturacion\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'encomienda_id' => $this->faker->randomElement(Encomienda::pluck('id')->toArray()),
            'tipoDoc' => $this->faker->randomElement(['01', '03']),
            'tipoOperacion' => $this->faker->randomElement(['0101', '0200']),
            'serie' => $this->faker->regexify('[A-Z]{4}'),
            'correlativo' => $this->faker->numberBetween(1, 99999999),
            'fechaEmision' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'formaPago_moneda' => $this->faker->randomElement(['PEN', 'USD']),
            'formaPago_tipo' => $this->faker->randomElement(['Contado', 'Credito']),
            'tipoMoneda' => $this->faker->randomElement(['PEN', 'USD']),
            'company_id' => $this->faker->randomElement(Company::pluck('id')->toArray()),
            'client_id' => $this->faker->randomElement(Customer::pluck('id')->toArray()),
            'mtoOperGravadas' => $this->faker->randomFloat(2, 100, 1000),
            'mtoIGV' => $this->faker->randomFloat(2, 18, 180),
            'totalImpuestos' => $this->faker->randomFloat(2, 18, 180),
            'valorVenta' => $this->faker->randomFloat(2, 100, 1000),
            'subTotal' => $this->faker->randomFloat(2, 118, 1180),
            'mtoImpVenta' => $this->faker->randomFloat(2, 118, 1180),
            'xml_path' => $this->faker->filePath(),
            'xml_hash' => $this->faker->sha256,
            'cdr_description' => $this->faker->sentence,
            'cdr_code' => $this->faker->numberBetween(0, 99),
            'monto_letras' => $this->faker->sentence,
        ];
    }
}
