<?php

namespace App\Models;

use App\Enums\ConditionType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * شروط کمپین ترکیبی (C04)
 * جدول: campaign_conditions
 */
class CampaignCondition extends Model
{
    protected $table = 'campaign_conditions';

    protected $fillable = [
        'campaign_version_id',
        'condition_type',
        'product_id',
        'category_id',
        'min_qty',
        'min_amount',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'condition_type' => ConditionType::class,
        ];
    }

    public function version(): BelongsTo
    {
        return $this->belongsTo(CampaignVersion::class, 'campaign_version_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
