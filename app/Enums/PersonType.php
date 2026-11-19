<?php

namespace App\Enums;

enum PersonType: string
{
    case Real = 'real';
    case Legal = 'legal';

    public function label(): string
    {
        return match ($this) {
            self::Real => 'حقیقی',
            self::Legal => 'حقوقی',
        };
    }
}
