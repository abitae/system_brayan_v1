<?php

namespace Database\Factories\Package;

use App\Models\Package\Encomienda;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Package\Paquete>
 */
class PaqueteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'encomienda_id' => Encomienda::inRandomOrder()->first()->id,
            'cantidad' => $this->faker->numberBetween(1, 99),
            'und_medida' => $this->faker->randomElement(['UND', 'M3', 'KG', 'LT']),
            'description' => $this->faker->sentence(4),
            'peso' => $this->faker->randomFloat(2, 0.1, 100),
            'amount' => $this->faker->randomFloat(2, 5, 500),
            'sub_total' => function (array $attributes) {
                return $attributes['cantidad'] * $attributes['amount'];
            },
        ];
    }
}
