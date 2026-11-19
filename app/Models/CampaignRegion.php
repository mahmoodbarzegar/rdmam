<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * مناطق جغرافیایی مشمول کمپین
 * جدول: campaign_regions
 */
class CampaignRegion extends Model
{
    protected $table = 'campaign_regions';

    protected $fillable = [
        'campaign_version_id',
        'province_id',
        'city_id',
    ];

    protected function casts(): array
    {
        return [
        ];
    }

    public function version(): BelongsTo
    {
        return $this->belongsTo(CampaignVersion::class, 'campaign_version_id');
    }

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
