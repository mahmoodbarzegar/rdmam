<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * دسته‌بندی‌های کالا
 * جدول: product_categories
 */
class Category extends Model
{
    protected $table = 'categories';

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
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
