<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SiteSettingController extends Controller
{
    public function index()
    {
        // Ambil beberapa kunci penting untuk form gabungan
        $keys = ['whatsapp_link','contact','maps_embed','about_gallery','visi_misi'];
        $settings = collect($keys)->mapWithKeys(fn($k)=>[$k => SiteSetting::get($k)]);
        return view('admin.settings.index', compact('settings'));
    }

    public function edit(string $key)
    {
        $value = SiteSetting::get($key, []);
        return view('admin.settings.edit', compact('key','value'));
    }

    public function update(Request $request, string $key)
    {
        // Validasi generik (sesuaikan di view per key)
        $value = $request->input('value');
        if (!is_array($value)) {
            $value = ['value' => $value]; // bungkus agar konsisten JSON
        }

        SiteSetting::set($key, $value);
        return back()->with('success', 'Setting updated.');
    }

    /** Update beberapa setting sekaligus (form gabungan) */
    public function updateMany(Request $request)
    {
        $data = $request->validate([
            'settings' => ['required','array'],
        ]);

        foreach ($data['settings'] as $key => $value) {
            SiteSetting::set($key, is_array($value) ? $value : ['value'=>$value]);
        }

        return back()->with('success','Settings saved.');
    }
}
