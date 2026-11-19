<?php

namespace App\Models;

use App\Enums\SyncErrorType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * فهرست خطاهای مرکزی کالا
 * جدول: product_sync_errors
 */
class ProductSyncError extends Model
{
    protected $table = 'product_sync_errors';

    protected $fillable = [
        'product_id',
        'erp_id',
        'error_type',
        'message',
        'payload',
        'resolved_at',
        'resolved_by',
    ];

    protected function casts(): array
    {
        return [
            'payload' => 'array',
            'resolved_at' => 'datetime',
            'error_type' => SyncErrorType::class,
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
