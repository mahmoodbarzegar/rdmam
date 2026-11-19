<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * گروه‌های کالا
 * جدول: product_groups
 */
class ProductGroup extends Model
{
    protected $table = 'product_groups';

    protected $fillable = [
        'parent_id',
        'name',
        'erp_code',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
        ];
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(ProductGroup::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(ProductGroup::class, 'parent_id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
