<?php

namespace App\Models;

use App\Enums\ProductDefaultUnit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Price extends Model
{
    protected $fillable = [
        'product_id',
        'unit',
        'price',
        'start_date',
        'end_date',
        'approved_at',
        'is_approved',
        'erp_title',
    ];

    protected function casts(): array
    {
        return [
            'unit' => ProductDefaultUnit::class,
            'price' => 'integer',
            'start_date' => 'date',
            'end_date' => 'date',
            'approved_at' => 'datetime',
            'is_approved' => 'boolean',
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
