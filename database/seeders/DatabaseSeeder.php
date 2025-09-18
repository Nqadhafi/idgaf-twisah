<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
    // Admin
    \App\Models\User::factory()->create([
        'name' => 'Admin',
        'email' => 'admin@example.com',
        'username' => 'admin',
        'password' => bcrypt('password'),
        'is_admin' => true,
    ]);

    // Settings
    \App\Models\SiteSetting::factory()->whatsapp()->create();
    \App\Models\SiteSetting::factory()->contact()->create();
    \App\Models\SiteSetting::factory()->maps()->create();
    \App\Models\SiteSetting::factory()->aboutGallery()->create();

    // Pages
    $home    = \App\Models\Page::factory()->published()->create(['title'=>'Home','slug'=>'/']);
    $about   = \App\Models\Page::factory()->published()->create(['title'=>'Visi Misi','slug'=>'visi-misi']);
    $services= \App\Models\Page::factory()->published()->create(['title'=>'Services','slug'=>'services']);
    $books   = \App\Models\Page::factory()->published()->create(['title'=>'Buku Terbit','slug'=>'buku-terbit']);
    $contact = \App\Models\Page::factory()->published()->create(['title'=>'Contact','slug'=>'contact']);

    // Sections Home
    \App\Models\Section::factory()->for($home)->hero()->create(['sort_order'=>0]);
    \App\Models\Section::factory()->for($home)->services()->create(['sort_order'=>1]);
    \App\Models\Section::factory()->for($home)->packages()->create(['sort_order'=>2]);
    \App\Models\Section::factory()->for($home)->howItWorks()->create(['sort_order'=>3]);
    \App\Models\Section::factory()->for($home)->portfolio()->create(['sort_order'=>4]);
    \App\Models\Section::factory()->for($home)->testimonials()->create(['sort_order'=>5]);
    \App\Models\Section::factory()->for($home)->faq()->create(['sort_order'=>6]);
    \App\Models\Section::factory()->for($home)->contact()->create(['sort_order'=>7]);

    // Sections lain
    \App\Models\Section::factory()->for($about)->aboutGallery()->create();
    \App\Models\Section::factory()->for($services)->services()->create();
    \App\Models\Section::factory()->for($books)->portfolio()->create();
    \App\Models\Section::factory()->for($contact)->contact()->create();

    // Konten
    \App\Models\PortfolioItem::factory()->count(12)->create();
    \App\Models\Testimonial::factory()->count(6)->create();
    \App\Models\Faq::factory()->count(8)->create();
    }
}
