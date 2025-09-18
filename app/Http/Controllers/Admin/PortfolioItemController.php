<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PortfolioItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PortfolioItemController extends Controller
{
    public function index(Request $request)
    {
        $q = PortfolioItem::query()
            ->when($request->filled('q'), fn($x)=>$x->where('title','like','%'.$request->q.'%')->orWhere('author','like','%'.$request->q.'%'))
            ->orderBy('sort_order')->orderByDesc('id');

        $items = $q->paginate(15)->withQueryString();
        return view('admin.portfolio.index', compact('items'));
    }

    public function create()
    {
        return view('admin.portfolio.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => ['required','string','max:200'],
            'author'      => ['nullable','string','max:160'],
            'excerpt'     => ['nullable','string'],
            'is_featured' => ['sometimes','boolean'],
            'is_visible'  => ['sometimes','boolean'],
            'sort_order'  => ['nullable','integer','min:0'],
            'cover'       => ['nullable','image'],
        ]);

        if ($request->hasFile('cover')) {
            $data['cover_path'] = $request->file('cover')->store('covers', 'public');
        }

        $item = PortfolioItem::create($data);
        return redirect()->route('admin.portfolio.edit', $item)->with('success','Portfolio item created.');
    }

    public function edit(PortfolioItem $portfolio)
    {
        return view('admin.portfolio.edit', ['item'=>$portfolio]);
    }

    public function update(Request $request, PortfolioItem $portfolio)
    {
        $data = $request->validate([
            'title'       => ['required','string','max:200'],
            'author'      => ['nullable','string','max:160'],
            'excerpt'     => ['nullable','string'],
            'is_featured' => ['sometimes','boolean'],
            'is_visible'  => ['sometimes','boolean'],
            'sort_order'  => ['nullable','integer','min:0'],
            'cover'       => ['nullable','image'],
        ]);

        if ($request->hasFile('cover')) {
            if ($portfolio->cover_path) {
                Storage::disk('public')->delete($portfolio->cover_path);
            }
            $data['cover_path'] = $request->file('cover')->store('covers', 'public');
        }

        $portfolio->update($data);
        return back()->with('success','Portfolio item updated.');
    }

    public function destroy(PortfolioItem $portfolio)
    {
        if ($portfolio->cover_path) {
            Storage::disk('public')->delete($portfolio->cover_path);
        }
        $portfolio->delete();
        return back()->with('success','Portfolio item deleted.');
    }

    /** POST: toggle featured */
    public function toggleFeatured(PortfolioItem $portfolio)
    {
        $portfolio->is_featured = !$portfolio->is_featured;
        $portfolio->save();
        return response()->json(['ok'=>true,'is_featured'=>$portfolio->is_featured]);
    }

    /** POST: toggle visible */
    public function toggleVisibility(PortfolioItem $portfolio)
    {
        $portfolio->is_visible = !$portfolio->is_visible;
        $portfolio->save();
        return response()->json(['ok'=>true,'is_visible'=>$portfolio->is_visible]);
    }

    /** POST: reorder by ordered array of IDs */
    public function reorder(Request $request)
    {
        $ids = $request->validate(['ids'=>'required|array'])['ids'];
        foreach ($ids as $i => $id) {
            PortfolioItem::where('id', $id)->update(['sort_order'=>$i]);
        }
        return response()->json(['ok'=>true]);
    }
}
