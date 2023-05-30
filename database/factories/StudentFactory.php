<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'nim' => $this->faker->unique()->randomNumber(8),
            'gender' => $this->faker->randomElement(['L', 'P']),
            'address' => $this->faker->address,
            'major_id' => $this->faker->numberBetween(1, 3),
        ];
    }
}
