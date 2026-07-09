<?php

namespace Database\Factories\Configuration;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Configuration\Vehiculo>
 */
class VehiculoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomNumber(8, false),
            'marca' => 'TOYOTA',
            'modelo' => 'TOYOTA',
            'tipo' => 'INTERNO',
            'isActive' => true,
        ];
    }
}
