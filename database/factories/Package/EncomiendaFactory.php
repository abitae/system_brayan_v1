<?php

namespace Database\Factories\Package;

use App\Models\Configuration\Sucursal;
use App\Models\Configuration\Transportista;
use App\Models\Configuration\Vehiculo;
use App\Models\Package\Customer;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Package\Encomienda>
 */
class EncomiendaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => 'ENC-' . $this->faker->unique()->numerify('#####'),
            'user_id' => User::inRandomOrder()->first()->id,
            'transportista_id' => Transportista::inRandomOrder()->first()->id,
            'vehiculo_id' => Vehiculo::inRandomOrder()->first()->id,
            'customer_id' => Customer::inRandomOrder()->first()->id,
            'sucursal_id' => Sucursal::inRandomOrder()->first()->id,
            'customer_dest_id' => Customer::inRandomOrder()->first()->id,
            'sucursal_dest_id' => Sucursal::inRandomOrder()->first()->id,
            'customer_fact_id' => Customer::inRandomOrder()->first()->id,
            'cantidad' => $this->faker->numberBetween(1, 10),
            'monto' => $this->faker->randomFloat(2, 10, 5000),
            'monto_descuento' => $this->faker->optional()->randomFloat(2, 5, 500),
            'motivo_descuento' => $this->faker->optional()->sentence(),
            'doc_ticket' => null,
            'doc_guia' => null,
            'doc_factura' => null,
            'estado_pago' => $this->faker->randomElement(['PAGADO', 'CONTRA ENTREGA']),
            'tipo_pago' => $this->faker->randomElement(['Contado', 'Credito']),
            'metodo_pago' => $this->faker->randomElement(['Efectivo', 'Yape', 'Tarjeta', 'Transferencia']),
            'tipo_comprobante' => $this->faker->randomElement(['TICKET', 'FACTURA', 'BOLETA']),
            'tipoDocTraslado' => $this->faker->randomElement(['01', '03', '07', '31']),
            'docTraslado' => 'DT-' . $this->faker->unique()->numerify('#####'),
            'emisorDocTraslado' => $this->faker->unique()->numerify('###########'),
            'glosa' => $this->faker->sentence(),
            'observation' => $this->faker->optional()->paragraph(),
            'estado_encomienda' => $this->faker->randomElement(['REGISTRADO']),
            'pin' => $this->faker->numberBetween(100, 999),
            'isTransbordo' => $this->faker->boolean(),
            'isHome' => $this->faker->boolean(),
            'isReturn' => $this->faker->boolean(),
            'isActive' => $this->faker->boolean(90), // 90% chance of being true
        ];
    }
}
