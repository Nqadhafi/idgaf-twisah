<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index(Request $request)
    {
        $q = Faq::query()
            ->when($request->filled('q'), fn($x)=>$x->where('question','like','%'.$request->q.'%'))
            ->orderBy('sort_order')->orderByDesc('id');

        $rows = $q->paginate(15)->withQueryString();
        return view('admin.faqs.index', compact('rows'));
    }

    public function create()
    {
        return view('admin.faqs.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'question'   => ['required','string','max:220'],
            'answer'     => ['required','string'],
            'sort_order' => ['nullable','integer','min:0'],
            'is_visible' => ['sometimes','boolean'],
        ]);

        $row = Faq::create($data);
        return redirect()->route('admin.faqs.edit', $row)->with('success','FAQ created.');
    }

    public function edit(Faq $faq)
    {
        return view('admin.faqs.edit', ['row'=>$faq]);
    }

    public function update(Request $request, Faq $faq)
    {
        $data = $request->validate([
            'question'   => ['required','string','max:220'],
            'answer'     => ['required','string'],
            'sort_order' => ['nullable','integer','min:0'],
            'is_visible' => ['sometimes','boolean'],
        ]);

        $faq->update($data);
        return back()->with('success','FAQ updated.');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();
        return back()->with('success','FAQ deleted.');
    }

    public function toggleVisibility(Faq $faq)
    {
        $faq->is_visible = !$faq->is_visible;
        $faq->save();
        return response()->json(['ok'=>true,'is_visible'=>$faq->is_visible]);
    }

    public function reorder(Request $request)
    {
        $ids = $request->validate(['ids'=>'required|array'])['ids'];
        foreach ($ids as $i => $id) {
            Faq::where('id',$id)->update(['sort_order'=>$i]);
        }
        return response()->json(['ok'=>true]);
    }
}
