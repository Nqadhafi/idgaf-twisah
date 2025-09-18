<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Section extends Model
{
    use SoftDeletes , HasFactory;

    protected $fillable = [
        'page_id', 'type', 'payload', 'sort_order', 'is_visible',
    ];

    protected $casts = [
        'payload'    => 'array',
        'sort_order' => 'integer',
        'is_visible' => 'boolean',
    ];

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    // Scopes
    public function scopeVisible(Builder $q): Builder
    {
        return $q->where('is_visible', true);
    }

    public function scopeOrdered(Builder $q): Builder
    {
        return $q->orderBy('sort_order');
    }

public const TYPE_HERO        = 'hero';
public const TYPE_SERVICES    = 'services';
public const TYPE_PACKAGES    = 'packages';
public const TYPE_HOW_IT_WORKS= 'how_it_works';
public const TYPE_PORTFOLIO   = 'portfolio';
public const TYPE_TESTIMONIALS= 'testimonials';
public const TYPE_FAQ         = 'faq';
public const TYPE_CONTACT     = 'contact';
public const TYPE_ABOUT_GALLERY = 'about_gallery';
}
