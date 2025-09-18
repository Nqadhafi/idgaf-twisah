<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/** @extends Factory<\App\Models\Testimonial> */
class TestimonialFactory extends Factory
{
    public function definition(): array
    {
        return [
            'author'      => $this->faker->name(),
            'role'        => $this->faker->jobTitle(),
            'quote'       => $this->faker->sentences(3, true),
            'avatar_path' => 'avatars/'.Str::random(20).'.jpg',
            'sort_order'  => $this->faker->numberBetween(0, 100),
            'is_visible'  => $this->faker->boolean(95),
        ];
    }
}
