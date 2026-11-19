<?php

namespace App\Models;

use App\Enums\CampaignItemRole;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * کالا و دسته‌بندی کالای مشمول یا مستثنا
 * جدول: campaign_items
 */
class CampaignItem extends Model
{
    protected $table = 'campaign_items';

    protected $fillable = [
        'campaign_version_id',
        'product_id',
        'category_id',
        'role',
        'min_qty',
    ];

    protected function casts(): array
    {
        return [
            'role' => CampaignItemRole::class,
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
