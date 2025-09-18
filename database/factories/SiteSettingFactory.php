<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<\App\Models\SiteSetting> */
class SiteSettingFactory extends Factory
{
    public function definition(): array
    {
        return [
            'key'   => $this->faker->unique()->slug(),
            'value' => ['text' => $this->faker->sentence()],
        ];
    }

    // STATES cepat untuk keys penting
    public function whatsapp(): self
    {
        return $this->state(fn()=>[
            'key'   => 'whatsapp_link',
            'value' => ['url' => 'https://wa.me/6281234567890', 'label' => 'Chat WhatsApp'],
        ]);
    }

    public function contact(): self
    {
        return $this->state(fn()=>[
            'key'   => 'contact',
            'value' => [
                'address' => $this->faker->address(),
                'phone'   => '0812-3456-7890',
                'email'   => 'halo@shabatprinting.id',
            ],
        ]);
    }

    public function maps(): self
    {
        return $this->state(fn()=>[
            'key'   => 'maps_embed',
            'value' => [
                // Simpan sebagai string di JSON agar aman saat render {!! !!}
                'iframe' => '<iframe src="https://maps.google.com/..."></iframe>',
            ],
        ]);
    }

    public function aboutGallery(): self
    {
        return $this->state(fn()=>[
            'key'   => 'about_gallery',
            'value' => [
                'images' => collect(range(1,8))->map(
                    fn($i)=>['path'=>"gallery/img{$i}.jpg",'alt'=>"Gallery {$i}"]
                )->toArray(),
            ],
        ]);
    }
}
