<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;

class ContactController extends Controller
{
    public function index()
    {
        $contact = SiteSetting::get('contact', []);
        $maps    = SiteSetting::get('maps_embed', []);
        $whatsapp= SiteSetting::get('whatsapp_link', []);
        return view('public.contact', compact('contact','maps','whatsapp'));
    }
}
