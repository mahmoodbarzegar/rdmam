<?php

namespace App\Enums;

enum ProductDefaultUnit: string
{
    case Piece = 'piece';       // عدد
    case Pack = 'pack';         // بسته
    case Pair = 'pair';         // جفت
    case Kg = 'kg'; // کیلوگرم

    public function label(): string
    {
        return match ($this) {
            self::Piece => 'عدد',
            self::Pack => 'بسته',
            self::Pair => 'جفت',
            self::Kg => 'کیلوگرم',
        };
    }

}
