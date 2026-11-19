<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Cache;

/**
 * تنظیمات سراسری
 * جدول: system_settings
 */
class SystemSetting extends Model
{
    protected $table = 'system_settings';

    protected $fillable = [
        'key',
        'value',
        'description',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'value' => 'array',
        ];
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

public static function getValue(string $key, mixed $default = null): mixed
{
    return Cache::remember("setting:$key", 300, function () use ($key, $default) {
        $row = static::where('key', $key)->first();
        return $row ? $row->value : $default;
    });
}

public static function put(string $key, mixed $value, ?int $userId = null): void
{
    static::updateOrCreate(['key' => $key], ['value' => $value, 'updated_by' => $userId]);
    Cache::forget("setting:$key");
}
}
