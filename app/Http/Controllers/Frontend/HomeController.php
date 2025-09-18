<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\{Page, Section, PortfolioItem, Testimonial, Faq};

class HomeController extends Controller
{
    public function index()
    {
        // Cari page ber-slug '/' jika ada, jika tidak ya tampilkan blok default dari DB lain
        $page = Page::published()->where('slug','/')->first();

        $sections = $page
            ? $page->sections()->visible()->ordered()->get()
            : collect();

        // Optional: jika tidak memakai sections dinamis, bisa fallback data ringkas:
        $featured = PortfolioItem::visible()->featured()->ordered()->take(8)->get();
        $testimonials = Testimonial::visible()->ordered()->take(6)->get();
        $faqs = Faq::visible()->ordered()->take(6)->get();

        return view('public.home', compact('page','sections','featured','testimonials','faqs'));
    }
}
