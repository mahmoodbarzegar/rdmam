<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * پله‌های تخفیف
 * جدول: campaign_tiers
 */
class CampaignTier extends Model
{
    protected $table = 'campaign_tiers';

    protected $fillable = [
        'campaign_version_id',
        'from_value',
        'to_value',
        'value',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'value' => 'decimal:2',
        ];
    }

    public function version(): BelongsTo
    {
        return $this->belongsTo(CampaignVersion::class, 'campaign_version_id');
    }
}
