<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * دسته‌بندی‌های کالا
 * جدول: product_categories
 */
class ProductCategory extends Model
{
    protected $table = 'product_categories';

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
        return $this->belongsTo(ProductCategory::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(ProductCategory::class, 'parent_id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
