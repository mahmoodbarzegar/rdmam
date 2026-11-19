<?php

namespace App\Models;

use App\Enums\IncentiveType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * نسخه‌های کمپین (فیلدهای مشترک و اختصاصی)
 * جدول: campaign_versions
 */
class CampaignVersion extends Model
{
    protected $table = 'campaign_versions';

    protected $fillable = [
        'campaign_id',
        'version_no',
        'title',
        'description',
        'incentive_type',
        'incentive_value',
        'starts_at',
        'ends_at',
        'priority',
        'audience_type',
        'all_branches',
        'all_regions',
        'min_order_amount',
        'max_discount_per_order',
        'max_uses_per_customer',
        'budget_limit',
        'orders_limit',
        'unit_scope',
        'min_qty',
        'max_discounted_qty',
        'qty_basis',
        'discount_on',
        'max_countable_qty',
        'amount_basis',
        'max_eligible_amount',
        'apply_to',
        'conditions_operator',
        'is_published',
        'published_at',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'incentive_value' => 'decimal:2',
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
            'all_branches' => 'boolean',
            'all_regions' => 'boolean',
            'is_published' => 'boolean',
            'published_at' => 'datetime',
            'incentive_type' => IncentiveType::class,
        ];
    }

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    public function tiers(): HasMany
    {
        return $this->hasMany(CampaignTier::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(CampaignItem::class);
    }

    public function conditions(): HasMany
    {
        return $this->hasMany(CampaignCondition::class);
    }

    public function regions(): HasMany
    {
        return $this->hasMany(CampaignRegion::class);
    }

    public function branches(): BelongsToMany
    {
        return $this->belongsToMany(Branch::class, 'campaign_branches');
    }

    public function customers(): BelongsToMany
    {
        return $this->belongsToMany(Customer::class, 'campaign_customers');
    }

    public function clubLevels(): BelongsToMany
    {
        return $this->belongsToMany(ClubLevel::class, 'campaign_club_levels');
    }

public function isRunningAt(?\DateTimeInterface $at = null): bool
{
    $at ??= now();

    return $this->is_published && $this->starts_at <= $at && $this->ends_at >= $at;
}
}
