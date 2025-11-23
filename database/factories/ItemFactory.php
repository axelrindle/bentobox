<?php

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
            'name' => $this->faker->word(),
            'is_consumable' => $this->faker->boolean(0.3),
            'is_lendable' => $this->faker->boolean(0.8),
            'amount' => $this->faker->numberBetween(1, 50),
            'tags' => array_map(
                fn () => $this->faker->word(),
                array_fill(0, max(1, $this->faker->randomDigit()), ''),
            ),
        ];
    }
}
