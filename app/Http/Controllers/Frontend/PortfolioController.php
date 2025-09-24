<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\PortfolioItem;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function index(Request $request)
    {
        $q = PortfolioItem::visible()
            ->when($request->boolean('featured'), fn($x)=>$x->featured())
            ->when($request->filled('q'), fn($x)=>$x->where('title','like','%'.$request->q.'%')->orWhere('author','like','%'.$request->q.'%'))
            ->ordered();

        $items = $q->paginate(12)->withQueryString();
        // dd($items);
        return view('public.portfolio.index', compact('items'));
    }

    public function show(PortfolioItem $portfolio)
    {
        // Jika ingin detail tiap buku terbit
        abort_if(!$portfolio->is_visible, 404);
        return view('public.portfolio.show', ['item'=>$portfolio]);
    }
}
