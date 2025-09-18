<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/** @extends Factory<\App\Models\Page> */
class PageFactory extends Factory
{
    public function definition(): array
    {
        $title = $this->faker->unique()->sentence(3);
        $published = $this->faker->boolean(85);

        return [
            'title'            => $title,
            'slug'             => Str::slug($title),
            'meta_title'       => $title,
            'meta_description' => $this->faker->realText(160),
            'is_published'     => $published,
            'published_at'     => $published ? now()->subDays($this->faker->numberBetween(0, 30)) : null,
        ];
    }

    public function published(): self
    {
        return $this->state(fn () => [
            'is_published' => true,
            'published_at' => now(),
        ]);
    }

    public function draft(): self
    {
        return $this->state(fn () => [
            'is_published' => false,
            'published_at' => null,
        ]);
    }
}
