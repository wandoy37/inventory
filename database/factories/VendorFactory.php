<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vendor>
 */
class VendorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'    => $this->faker->company(),
            'address' => $this->faker->address(),
            'email'   => $this->faker->unique()->safeEmail(),
            'phone'   => $this->faker->phoneNumber(),
        ];
    }
}
