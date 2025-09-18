<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Page, Section, PortfolioItem, Testimonial, Faq};
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'pages'       => Page::count(),
            'sections'    => Section::count(),
            'portfolio'   => PortfolioItem::count(),
            'testimonials'=> Testimonial::count(),
            'faqs'        => Faq::count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
