<?php

namespace App\Models;

use App\Enums\PointTransactionType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * دفتر امتیاز (Ledger)
 * جدول: club_point_transactions
 */
class ClubPointTransaction extends Model
{
    protected $table = 'club_point_transactions';

    protected $fillable = [
        'customer_id',
        'type',
        'points',
        'remaining_points',
        'order_id',
        'erp_invoice_id',
        'expires_at',
        'reason',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'points' => 'decimal:2',
            'remaining_points' => 'decimal:2',
            'expires_at' => 'date',
            'type' => PointTransactionType::class,
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(ErpInvoice::class, 'erp_invoice_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
