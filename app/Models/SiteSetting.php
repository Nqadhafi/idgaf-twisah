<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
Use Illuminate\Database\Eloquent\Factories\HasFactory;

class SiteSetting extends Model
{
    use HasFactory;
    protected $fillable = ['key', 'value'];

    protected $casts = [
        'value' => 'array', // bisa string/array/object—disimpan sebagai JSON
    ];

    /** Ambil nilai setting. Jika tidak ada, kembalikan default. */
    public static function get(string $key, $default = null)
    {
        $row = static::query()->where('key', $key)->first();
        return $row?->value ?? $default;
    }

    /**
     * Set/update nilai setting.
     * Contoh:
     *   SiteSetting::set('contact', ['phone' => '08xx', 'email' => '...']);
     */
    public static function set(string $key, $value): self
    {
        return static::query()->updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }
}
