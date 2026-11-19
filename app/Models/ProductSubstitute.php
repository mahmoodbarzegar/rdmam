<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * قطعات جایگزین
 * جدول: product_substitutes
 */
class ProductSubstitute extends Model
{
    protected $table = 'product_substitutes';

    protected $fillable = [
        'product_id',
        'substitute_id',
        'relation_type',
        'approved_by',
    ];

    protected function casts(): array
    {
        return [
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function substitute(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'substitute_id');
    }
}
