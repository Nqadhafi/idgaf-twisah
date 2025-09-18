<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Page extends Model
{
    use SoftDeletes , HasFactory;

    protected $fillable = [
        'title', 'slug', 'meta_title', 'meta_description',
        'is_published', 'published_at',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    // Relasi
    public function sections(): HasMany
    {
        return $this->hasMany(Section::class)->orderBy('sort_order');
    }

    // Scopes
    public function scopePublished(Builder $q): Builder
    {
        return $q->where('is_published', true)
                 ->where(function ($q) {
                     $q->whereNull('published_at')
                       ->orWhere('published_at', '<=', now());
                 });
    }

    // Helper route binding by slug (opsional)
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
