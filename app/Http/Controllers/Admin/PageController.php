<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Page};
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PageController extends Controller
{
    public function index(Request $request)
    {
        $q = Page::query()
            ->when($request->filled('q'), fn($x)=>$x->where('title','like','%'.$request->q.'%')->orWhere('slug','like','%'.$request->q.'%'))
            ->orderByDesc('id');

        $pages = $q->paginate(15)->withQueryString();
        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'            => ['required','string','max:160'],
            'slug'             => ['required','string','max:160', Rule::unique('pages','slug'), 'regex:/^\/?[a-z0-9\-\/]+$/i'],
            'meta_title'       => ['nullable','string','max:180'],
            'meta_description' => ['nullable','string'],
            'is_published'     => ['sometimes','boolean'],
            'published_at'     => ['nullable','date'],
        ]);

        $page = Page::create($data);
        return redirect()->route('admin.pages.edit', $page)->with('success','Page created.');
    }

    public function edit(Page $page)
    {
        $page->load('sections');
        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $data = $request->validate([
            'title'            => ['required','string','max:160'],
            'slug'             => ['required','string','max:160', Rule::unique('pages','slug')->ignore($page->id), 'regex:/^\/?[a-z0-9\-\/]+$/i'],
            'meta_title'       => ['nullable','string','max:180'],
            'meta_description' => ['nullable','string'],
            'is_published'     => ['sometimes','boolean'],
            'published_at'     => ['nullable','date'],
        ]);

        $page->update($data);
        return back()->with('success','Page updated.');
    }

    public function destroy(Page $page)
    {
        $page->delete();
        return back()->with('success','Page deleted.');
    }
}
