<?php

namespace App\Enums;

enum PaymentItemType: string
{
    case Check = 'check';
    case Cash = 'cash';

    public function label(): string
    {
        return match ($this) {
            self::Check => 'چک',
            self::Cash => 'نقدی',
        };
    }
}
