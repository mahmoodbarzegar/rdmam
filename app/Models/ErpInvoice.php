<?php

namespace App\Models;

use App\Enums\InvoiceType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * فاکتور و مرجوعی دریافتی از ERP
 * جدول: erp_invoices
 */
class ErpInvoice extends Model
{
    protected $table = 'erp_invoices';

    protected $fillable = [
        'customer_id',
        'order_id',
        'erp_id',
        'number',
        'type',
        'invoice_date',
        'gross',
        'discount',
        'net',
        'tax',
        'shipping',
        'total',
        'status',
        'erp_synced_at',
    ];

    protected function casts(): array
    {
        return [
            'invoice_date' => 'date',
            'erp_synced_at' => 'datetime',
            'type' => InvoiceType::class,
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
}
