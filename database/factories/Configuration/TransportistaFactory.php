<?php

namespace Database\Factories\Configuration;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Configuration\Transportista>
 */
class TransportistaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'licencia' => $this->faker->randomNumber(8, false),
            'dni' => $this->faker->randomNumber(8, false),
            'name' => $this->faker->name,
            'tipo' => 'INTERNO',
            'isActive' => true,
        ];
    }
}
