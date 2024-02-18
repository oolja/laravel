<?php

declare(strict_types=1);

namespace Database\Factories;

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
        return [
            'name' => fake()->word(),
            'description' => fake()->sentence(10),
            'image_id' => null,
            'price' => fake()->randomFloat(2, 0, 8),
            'active' => fake()->boolean,
//            'priority' => fake()->randomDigitNotNull(),
        ];
    }
}
