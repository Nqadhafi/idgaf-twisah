<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    public function index(Request $request)
    {
        $q = Testimonial::query()
            ->when($request->filled('q'), fn($x)=>$x->where('author','like','%'.$request->q.'%')->orWhere('role','like','%'.$request->q.'%'))
            ->orderBy('sort_order')->orderByDesc('id');

        $rows = $q->paginate(15)->withQueryString();
        return view('admin.testimonials.index', compact('rows'));
    }

    public function create()
    {
        return view('admin.testimonials.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'author'     => ['required','string','max:160'],
            'role'       => ['nullable','string','max:160'],
            'quote'      => ['required','string'],
            'sort_order' => ['nullable','integer','min:0'],
            'is_visible' => ['sometimes','boolean'],
            'avatar'     => ['nullable','image'],
        ]);

        if ($request->hasFile('avatar')) {
            $data['avatar_path'] = $request->file('avatar')->store('avatars','public');
        }

        $row = Testimonial::create($data);
        return redirect()->route('admin.testimonials.edit', $row)->with('success','Testimonial created.');
    }

    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.edit', ['row'=>$testimonial]);
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $data = $request->validate([
            'author'     => ['required','string','max:160'],
            'role'       => ['nullable','string','max:160'],
            'quote'      => ['required','string'],
            'sort_order' => ['nullable','integer','min:0'],
            'is_visible' => ['sometimes','boolean'],
            'avatar'     => ['nullable','image'],
        ]);

        if ($request->hasFile('avatar')) {
            if ($testimonial->avatar_path) {
                Storage::disk('public')->delete($testimonial->avatar_path);
            }
            $data['avatar_path'] = $request->file('avatar')->store('avatars','public');
        }

        $testimonial->update($data);
        return back()->with('success','Testimonial updated.');
    }

    public function destroy(Testimonial $testimonial)
    {
        if ($testimonial->avatar_path) {
            Storage::disk('public')->delete($testimonial->avatar_path);
        }
        $testimonial->delete();
        return back()->with('success','Testimonial deleted.');
    }

    public function toggleVisibility(Testimonial $testimonial)
    {
        $testimonial->is_visible = !$testimonial->is_visible;
        $testimonial->save();
        return response()->json(['ok'=>true,'is_visible'=>$testimonial->is_visible]);
    }

    public function reorder(Request $request)
    {
        $ids = $request->validate(['ids'=>'required|array'])['ids'];
        foreach ($ids as $i => $id) {
            Testimonial::where('id',$id)->update(['sort_order'=>$i]);
        }
        return response()->json(['ok'=>true]);
    }
}
