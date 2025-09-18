<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class PortfolioItem extends Model
{
    use SoftDeletes , HasFactory;

    protected $fillable = [
        'title', 'author', 'excerpt', 'cover_path',
        'is_featured', 'sort_order', 'is_visible',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_visible'  => 'boolean',
        'sort_order'  => 'integer',
    ];

    // Scopes
    public function scopeVisible(Builder $q): Builder
    {
        return $q->where('is_visible', true);
    }

    public function scopeFeatured(Builder $q): Builder
    {
        return $q->where('is_featured', true);
    }

    public function scopeOrdered(Builder $q): Builder
    {
        return $q->orderBy('sort_order')->orderByDesc('id');
    }

    // Accessor URL cover (praktis untuk Blade)
    public function getCoverUrlAttribute(): ?string
    {
        return $this->cover_path ? Storage::url($this->cover_path) : null;
    }

    protected $appends = ['cover_url'];
}
