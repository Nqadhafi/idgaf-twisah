<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key', 120)->unique();        // contoh: whatsapp_link, contact_email, maps_embed, about_gallery
            $table->json('value')->nullable();           // fleksibel: string/objek/array tersimpan di JSON
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('site_settings');
    }
};
