<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('portfolio_items', function (Blueprint $table) {
            $table->id();
            $table->string('title', 200);
            $table->string('author', 160)->nullable();
            $table->text('excerpt')->nullable();
            $table->string('cover_path', 255)->nullable(); // storage path (public)
            $table->boolean('is_featured')->default(false);
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_visible')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['is_featured', 'is_visible']);
            $table->index('sort_order');
        });
    }

    public function down(): void {
        Schema::dropIfExists('portfolio_items');
    }
};
