<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Page, Section};
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SectionController extends Controller
{
    /** Tipe section yang diizinkan */
    private const ALLOWED_TYPES = [
        'hero','services','packages','how_it_works','portfolio',
        'testimonials','faq','contact','about_gallery',
    ];

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
            'type'       => ['required','string','max:50', Rule::in(self::ALLOWED_TYPES)],
            // payload datang sebagai string JSON dari <textarea>
            'payload'    => ['nullable','string'],
            'sort_order' => ['nullable','integer','min:0'],
            'is_visible' => ['sometimes','boolean'],
        ]);

        // Decode payload JSON (string) -> array
        $payload = $this->decodePayloadToArray($data['payload'] ?? null);
        if ($payload === false) {
            return back()
                ->withErrors(['payload' => 'Payload harus berformat JSON yang valid.'])
                ->withInput();
        }
        $data['payload'] = $payload ?: null;

        // Normalisasi boolean & sort order
        $data['is_visible'] = $request->boolean('is_visible');
        $data['sort_order'] = $data['sort_order'] ?? $this->nextSortOrder($page);

        $data['page_id'] = $page->id;

        Section::create($data);

        return redirect()
            ->route('admin.pages.sections.index', $page)
            ->with('success','Section added.');
    }

    public function edit(Page $page, Section $section)
    {
        return view('admin.sections.edit', compact('page','section'));
    }

    public function update(Request $request, Page $page, Section $section)
    {
        $data = $request->validate([
            'type'       => ['required','string','max:50', Rule::in(self::ALLOWED_TYPES)],
            'payload'    => ['nullable','string'],
            'sort_order' => ['nullable','integer','min:0'],
            'is_visible' => ['sometimes','boolean'],
        ]);

        $payload = $this->decodePayloadToArray($data['payload'] ?? null);
        if ($payload === false) {
            return back()
                ->withErrors(['payload' => 'Payload harus berformat JSON yang valid.'])
                ->withInput();
        }
        $data['payload']    = $payload ?: null;
        $data['is_visible'] = $request->has('is_visible')
            ? $request->boolean('is_visible')
            : (bool) $section->is_visible;

        // Kalau sort_order dikosongkan, otomatis isi ke urutan terakhir
        if (!array_key_exists('sort_order', $data) || $data['sort_order'] === null) {
            $data['sort_order'] = $section->sort_order ?? $this->nextSortOrder($page);
        }

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
        $validated = $request->validate([
            'ids'   => ['required','array','min:1'],
            'ids.*' => ['integer','distinct'],
        ]);

        foreach ($validated['ids'] as $i => $id) {
            Section::where('page_id', $page->id)
                ->where('id', $id)
                ->update(['sort_order' => $i]);
        }

        return response()->json(['ok'=>true]);
    }

    /** POST: toggle visible */
    public function toggleVisibility(Request $request, Page $page, Section $section)
    {
        $section->is_visible = !$section->is_visible;
        $section->save();

        return response()->json(['ok'=>true,'is_visible'=>(bool)$section->is_visible]);
    }

    /**
     * Decode payload JSON string -> array|null
     * return false jika JSON invalid.
     */
    private function decodePayloadToArray(?string $value): array|null|false
    {
        if ($value === null) return null;
        $trim = trim($value);
        if ($trim === '') return null;

        $decoded = json_decode($trim, true);
        if (json_last_error() !== JSON_ERROR_NONE) return false;

        // Pastikan array (bukan scalar)
        return is_array($decoded) ? $decoded : null;
    }

    /** Ambil urutan berikutnya untuk page ini */
    private function nextSortOrder(Page $page): int
    {
        $max = $page->sections()->max('sort_order');
        return is_null($max) ? 0 : ((int)$max + 1);
    }
}
