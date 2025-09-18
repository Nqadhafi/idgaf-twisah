<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Page;

/** @extends Factory<\App\Models\Section> */
class SectionFactory extends Factory
{
    public const TYPES = [
        'hero','services','packages','how_it_works',
        'portfolio','testimonials','faq','contact','about_gallery'
    ];

    public function definition(): array
    {
        $type = $this->faker->randomElement(self::TYPES);

        return [
            'page_id'    => Page::factory(),
            'type'       => $type,
            'payload'    => $this->payloadForType($type),
            'sort_order' => $this->faker->numberBetween(0, 10),
            'is_visible' => $this->faker->boolean(90),
        ];
    }

    // STATES PER-TYPE (opsional, biar mudah dipanggil)
    public function hero(): self         { return $this->state(fn()=>['type'=>'hero',         'payload'=>$this->payloadForType('hero')]); }
    public function services(): self     { return $this->state(fn()=>['type'=>'services',     'payload'=>$this->payloadForType('services')]); }
    public function packages(): self     { return $this->state(fn()=>['type'=>'packages',     'payload'=>$this->payloadForType('packages')]); }
    public function howItWorks(): self   { return $this->state(fn()=>['type'=>'how_it_works', 'payload'=>$this->payloadForType('how_it_works')]); }
    public function portfolio(): self    { return $this->state(fn()=>['type'=>'portfolio',    'payload'=>$this->payloadForType('portfolio')]); }
    public function testimonials(): self { return $this->state(fn()=>['type'=>'testimonials', 'payload'=>$this->payloadForType('testimonials')]); }
    public function faq(): self          { return $this->state(fn()=>['type'=>'faq',          'payload'=>$this->payloadForType('faq')]); }
    public function contact(): self      { return $this->state(fn()=>['type'=>'contact',      'payload'=>$this->payloadForType('contact')]); }
    public function aboutGallery(): self { return $this->state(fn()=>['type'=>'about_gallery','payload'=>$this->payloadForType('about_gallery')]); }

    private function payloadForType(string $type): array
    {
        return match ($type) {
            'hero' => [
                'title'      => $this->faker->sentence(5),
                'subtitle'   => $this->faker->sentence(10),
                'cta_text'   => 'Hubungi Kami',
                'cta_url'    => 'https://wa.me/6281234567890',
                'image_path' => 'banners/'.$this->faker->uuid().'.jpg',
            ],
            'services' => [
                'heading' => 'Layanan Kami',
                'items'   => collect(range(1,4))->map(fn($i)=>[
                    'icon'  => 'bi bi-check-circle',
                    'title' => $this->faker->words(3, true),
                    'desc'  => $this->faker->sentence(12),
                ])->toArray(),
            ],
            'packages' => [
                'heading' => 'Paket Penerbitan',
                'items'   => [
                    ['name'=>'Basic','price'=>'Rp990.000','features'=>['ISBN','Layout dasar','1x revisi']],
                    ['name'=>'Pro','price'=>'Rp1.990.000','features'=>['ISBN','Layout premium','3x revisi','Desain cover']],
                    ['name'=>'Business','price'=>'Rp3.990.000','features'=>['ISBN','Layout premium','Tak terbatas revisi','Konsultasi branding']],
                ],
            ],
            'how_it_works' => [
                'heading' => 'Alur Penerbitan',
                'steps'   => [
                    ['title'=>'Kirim Naskah','desc'=>'Unggah naskah & data penulis.'],
                    ['title'=>'Editing & Layout','desc'=>'Proses editorial dan tata letak.'],
                    ['title'=>'Desain Cover','desc'=>'Desain cover sesuai brief.'],
                    ['title'=>'Cetak & Terbit','desc'=>'Produksi dan distribusi.'],
                ],
            ],
            'portfolio' => [
                'heading'        => 'Buku Terbit',
                'show_featured'  => true,
                'limit'          => 8,
                'cta_more_label' => 'Lihat Semua',
                'cta_more_url'   => '/buku-terbit',
            ],
            'testimonials' => [
                'heading' => 'Apa Kata Penulis',
                'limit'   => 6,
            ],
            'faq' => [
                'heading' => 'Pertanyaan Umum',
                'limit'   => 6,
            ],
            'contact' => [
                'heading'        => 'Kontak Kami',
                'show_whatsapp'  => true,
                'show_form'      => false,
                'note'           => 'Kami balas cepat di jam kerja.',
            ],
            'about_gallery' => [
                'heading' => 'Galeri Kami',
                'images'  => collect(range(1,6))->map(
                    fn()=>['path'=>'gallery/'.$this->faker->uuid().'.jpg','alt'=>$this->faker->words(3, true)]
                )->toArray(),
            ],
            default => [],
        };
    }
}
