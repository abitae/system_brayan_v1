<?php

namespace Database\Factories\Package;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Package\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type_code' => $this->faker->randomElement(['dni', 'ruc']),
            'code' => function (array $attributes) {
                return $attributes['type_code'] === 'dni' 
                    ? $this->faker->numerify('########') 
                    : $this->faker->numerify('###########');
            },
            'name' => $this->faker->name(),
            'phone' => $this->faker->numerify('9########'), // Peruvian mobile format
            'email' => $this->faker->safeEmail(),
            'address' => $this->faker->streetAddress(),
            'ubigeo' => $this->faker->numerify('######'), // 6-digit Peruvian ubigeo code
            'isActive' => $this->faker->boolean(90), // 90% chance of being active
        ];
    }
}
