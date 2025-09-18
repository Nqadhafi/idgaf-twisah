<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('author', 160);
            $table->string('role', 160)->nullable(); // jabatan/peran
            $table->text('quote'); // isi testimoni
            $table->string('avatar_path', 255)->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_visible')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['is_visible', 'sort_order']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('testimonials');
    }
};
