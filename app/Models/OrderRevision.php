<?php

namespace App\Models;

use App\Enums\PricingPolicy;
use App\Enums\RevisionStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * نسخه‌های سفارش (قیمت‌گذاری و Snapshot)
 * جدول: order_revisions
 */
class OrderRevision extends Model
{
    protected $table = 'order_revisions';

    protected $fillable = [
        'order_id',
        'revision_no',
        'status',
        'pricing_policy',
        'campaign_id',
        'campaign_version_id',
        'campaign_title',
        'contract_discount_removed',
        'gross_total',
        'discount_total',
        'net_total',
        'tax_total',
        'payable_total',
        'priced_at',
        'submitted_at',
        'locked_at',
        'note',
    ];

    protected function casts(): array
    {
        return [
            'contract_discount_removed' => 'boolean',
            'priced_at' => 'datetime',
            'submitted_at' => 'datetime',
            'locked_at' => 'datetime',
            'status' => RevisionStatus::class,
            'pricing_policy' => PricingPolicy::class,
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    public function campaignVersion(): BelongsTo
    {
        return $this->belongsTo(CampaignVersion::class, 'campaign_version_id');
    }
}
