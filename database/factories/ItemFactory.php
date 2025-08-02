<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $nama = $this->faker->word; // Nama acak, misal "Obeng"
        $prefix = strtoupper(Str::substr($nama, 0, 2)); // Ambil 2 huruf pertama

        return [
            'name' => ucfirst($nama),
            'code' => $prefix . str_pad($this->faker->unique()->numberBetween(1, 999999), 6, '0', STR_PAD_LEFT),
            'description' => $this->faker->text(200)
        ];
    }
}
