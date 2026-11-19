<?php

namespace App\Enums;

enum ConditionType: string
{
    case ProductQty = 'product_qty';
    case CategoryQty = 'category_qty';
    case CartAmount = 'cart_amount';

    public function label(): string
    {
        return match ($this) {
            self::ProductQty => 'تعداد کالا',
            self::CategoryQty => 'تعداد دسته‌بندی کالا',
            self::CartAmount => 'مبلغ سبد',
        };
    }
}
