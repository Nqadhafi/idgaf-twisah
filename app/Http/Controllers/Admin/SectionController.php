<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Page, Section};
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SectionController extends Controller
{
    public function index(Page $page)
    {
        $sections = $page->sections()->orderBy('sort_order')->get();
        return view('admin.sections.index', compact('page','sections'));
    }

    public function create(Page $page)
    {
        return view('admin.sections.create', compact('page'));
    }

    public function store(Request $request, Page $page)
    {
        $data = $request->validate([
            'type'       => ['required','string','max:50', Rule::in(['hero','services','packages','how_it_works','portfolio','testimonials','faq','contact','about_gallery'])],
            'payload'    => ['nullable','array'],
            'sort_order' => ['nullable','integer','min:0'],
            'is_visible' => ['sometimes','boolean'],
        ]);

        $data['page_id'] = $page->id;
        Section::create($data);
        return redirect()->route('admin.pages.sections.index', $page)->with('success','Section added.');
    }

    public function edit(Page $page, Section $section)
    {
        return view('admin.sections.edit', compact('page','section'));
    }

    public function update(Request $request, Page $page, Section $section)
    {
        $data = $request->validate([
            'type'       => ['required','string','max:50', Rule::in(['hero','services','packages','how_it_works','portfolio','testimonials','faq','contact','about_gallery'])],
            'payload'    => ['nullable','array'],
            'sort_order' => ['nullable','integer','min:0'],
            'is_visible' => ['sometimes','boolean'],
        ]);

        $section->update($data);
        return back()->with('success','Section updated.');
    }

    public function destroy(Page $page, Section $section)
    {
        $section->delete();
        return back()->with('success','Section deleted.');
    }

    /** POST: reorder sections by ordered array of IDs */
    public function reorder(Request $request, Page $page)
    {
        $ids = $request->validate(['ids'=>'required|array'])['ids'];
        foreach ($ids as $i => $id) {
            Section::where('page_id', $page->id)->where('id', $id)->update(['sort_order'=>$i]);
        }
        return response()->json(['ok'=>true]);
    }

    /** POST: toggle visible */
    public function toggleVisibility(Request $request, Page $page, Section $section)
    {
        $section->is_visible = !$section->is_visible;
        $section->save();
        return response()->json(['ok'=>true,'is_visible'=>$section->is_visible]);
    }
}
