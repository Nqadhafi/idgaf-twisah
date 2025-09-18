<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<\App\Models\Faq> */
class FaqFactory extends Factory
{
    public function definition(): array
    {
        return [
            'question'   => rtrim($this->faker->sentence(6), '.') . '?',
            'answer'     => $this->faker->paragraph(),
            'sort_order' => $this->faker->numberBetween(0, 100),
            'is_visible' => $this->faker->boolean(95),
        ];
    }
}
