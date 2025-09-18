<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/** @extends Factory<\App\Models\PortfolioItem> */
class PortfolioItemFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title'       => $this->faker->unique()->sentence(3),
            'author'      => $this->faker->name(),
            'excerpt'     => $this->faker->realText(140),
            // Simpan path relatif ke disk 'public' -> url jadi /storage/...
            'cover_path'  => 'covers/'.Str::random(20).'.jpg',
            'is_featured' => $this->faker->boolean(25),
            'sort_order'  => $this->faker->numberBetween(0, 50),
            'is_visible'  => $this->faker->boolean(95),
        ];
    }

    public function featured(): self
    {
        return $this->state(fn()=>['is_featured'=>true]);
    }
}
