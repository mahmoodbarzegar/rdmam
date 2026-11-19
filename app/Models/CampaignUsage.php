<?php

namespace App\Models;

use App\Enums\CampaignUsageState;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * مصرف کمپین
 * جدول: campaign_usages
 */
class CampaignUsage extends Model
{
    protected $table = 'campaign_usages';

    protected $fillable = [
        'campaign_id',
        'campaign_version_id',
        'order_id',
        'order_revision_id',
        'customer_id',
        'discount_amount',
        'state',
    ];

    protected function casts(): array
    {
        return [
            'state' => CampaignUsageState::class,
        ];
    }

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    public function campaignVersion(): BelongsTo
    {
        return $this->belongsTo(CampaignVersion::class, 'campaign_version_id');
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
