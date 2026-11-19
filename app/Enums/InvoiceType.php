<?php

namespace App\Enums;

enum InvoiceType: string
{
    case Sale = 'sale';
    case Return = 'return';

    public function label(): string
    {
        return match ($this) {
            self::Sale => 'فروش',
            self::Return => 'برگشت از فروش',
        };
    }
}
