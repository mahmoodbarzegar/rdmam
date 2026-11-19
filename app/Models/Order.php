<?php

namespace App\Models;

use App\Enums\OrderBusinessStatus;
use App\Enums\OrderSyncStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * سفارش‌ها (سربرگ)
 * جدول: orders
 */
class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'number',
        'customer_id',
        'branch_id',
        'warehouse_id',
        'business_status',
        'sync_status',
        'current_revision_id',
        'approved_revision_id',
        'payment_terms',
        'submitted_at',
        'deadline_at',
        'correction_requested_at',
        'correction_deadline_at',
        'reminder_24_sent_at',
        'reminder_44_sent_at',
        'approved_by',
        'approved_at',
        'closed_at',
        'close_reason',
        'cancelled_by',
        'erp_id',
        'erp_order_number',
        'erp_status',
        'erp_status_at',
        'erp_accepted_at',
    ];

    protected function casts(): array
    {
        return [
            'payment_terms' => 'array',
            'submitted_at' => 'datetime',
            'deadline_at' => 'datetime',
            'correction_requested_at' => 'datetime',
            'correction_deadline_at' => 'datetime',
            'reminder_24_sent_at' => 'datetime',
            'reminder_44_sent_at' => 'datetime',
            'approved_at' => 'datetime',
            'closed_at' => 'datetime',
            'erp_status_at' => 'datetime',
            'erp_accepted_at' => 'datetime',
            'business_status' => OrderBusinessStatus::class,
            'sync_status' => OrderSyncStatus::class,
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function revisions(): HasMany
    {
        return $this->hasMany(OrderRevision::class);
    }

    public function currentRevision(): BelongsTo
    {
        return $this->belongsTo(OrderRevision::class, 'current_revision_id');
    }

    public function approvedRevision(): BelongsTo
    {
        return $this->belongsTo(OrderRevision::class, 'approved_revision_id');
    }

    public function decisions(): HasMany
    {
        return $this->hasMany(OrderDecision::class);
    }

    public function statusHistory(): HasMany
    {
        return $this->hasMany(OrderStatusHistory::class);
    }

    public function outbox(): HasMany
    {
        return $this->hasMany(ErpOutbox::class);
    }

    public function paymentRequest(): HasOne
    {
        return $this->hasOne(PaymentRequest::class);
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

public function scopeForBranch($q, int $branchId)
{
    return $q->where('branch_id', $branchId);
}

public function scopeOverdue($q)
{
    return $q->where('business_status', OrderBusinessStatus::PendingBranch)
        ->where('deadline_at', '<', now());
}

public function canBeEditedByCustomer(): bool
{
    return in_array($this->business_status, [OrderBusinessStatus::Draft, OrderBusinessStatus::NeedsCorrection], true);
}

/** مهلت پاسخ مشتری به درخواست اصلاح: حداکثر ۲۴ ساعت و هرگز بعد از پایان مهلت ۴۸ ساعته. */
public function correctionDeadlineFrom(Carbon $from): Carbon
{
    return $from->copy()->addHours(24)->min($this->deadline_at);
}
}
