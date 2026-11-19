<?php

namespace App\Enums;

enum CartUnit: string
{
    case Piece = 'piece';
    case Carton = 'carton';

    public function label(): string
    {
        return match ($this) {
            self::Piece => 'عدد',
            self::Carton => 'کارتن',
        };
    }
}
