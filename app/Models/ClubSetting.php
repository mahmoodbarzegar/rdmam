<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * پارامترهای باشگاه (تک‌ردیف)
 * جدول: club_settings
 */
class ClubSetting extends Model
{
    protected $table = 'club_settings';

    protected $fillable = [
        'level_period_days',
        'amount_per_point',
        'points_per_step',
        'rial_value_per_point',
        'points_expiry_days',
        'award_timing',
        'redemption_enabled',
        'min_redeem_points',
        'max_redeem_points_per_order',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'points_per_step' => 'decimal:2',
            'redemption_enabled' => 'boolean',
            'min_redeem_points' => 'decimal:2',
            'max_redeem_points_per_order' => 'decimal:2',
        ];
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

public static function current(): self
{
    return static::first() ?? static::create([]);
}
}
