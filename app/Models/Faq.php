<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Faq extends Model
{
    use SoftDeletes , HasFactory;

    protected $fillable = [
        'question', 'answer', 'sort_order', 'is_visible',
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
}
