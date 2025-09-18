<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Page;

class PageController extends Controller
{
    public function show(string $slug)
    {
        $page = Page::published()->where('slug', $slug)->firstOrFail();
        $sections = $page->sections()->visible()->ordered()->get();
        return view('public.page', compact('page','sections'));
    }
}
