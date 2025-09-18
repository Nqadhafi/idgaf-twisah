<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->constrained('pages')->cascadeOnDelete();
            $table->string('type', 50); // hero, services, packages, how_it_works, portfolio, testimonials, faq, contact, etc.
            $table->json('payload')->nullable(); // konten fleksibel per section
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_visible')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['page_id', 'type']);
            $table->index(['is_visible', 'sort_order']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('sections');
    }
};
