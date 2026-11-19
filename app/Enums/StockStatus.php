<?php

namespace App\Enums;

enum StockStatus: string
{
    case Orderable = 'orderable';
    case OutOfStock = 'out_of_stock';
    case NeedsUpdate = 'needs_update';

    public function label(): string
    {
        return match ($this) {
            self::Orderable => 'قابل سفارش',
            self::OutOfStock => 'ناموجود',
            self::NeedsUpdate => 'نیازمند به‌روزرسانی',
        };
    }
}
