<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
Use Illuminate\Database\Eloquent\Factories\HasFactory;
class Testimonial extends Model
{
    use SoftDeletes , HasFactory;

    protected $fillable = [
        'author', 'role', 'quote', 'avatar_path',
        'sort_order', 'is_visible',
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'is_visible' => 'boolean',
    ];

    public function scopeVisible(Builder $q): Builder
    {
        return $q->where('is_visible', true);
    }

    public function scopeOrdered(Builder $q): Builder
    {
        return $q->orderBy('sort_order')->orderByDesc('id');
    }

    public function getAvatarUrlAttribute(): ?string
    {
        return $this->avatar_path ? Storage::url($this->avatar_path) : null;
    }

    protected $appends = ['avatar_url'];
}
