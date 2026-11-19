<?php

namespace App\Enums;

enum SyncErrorType: string
{
    case UnitMismatch = 'unit_mismatch';
    case DuplicateCode = 'duplicate_code';
    case InvalidPrice = 'invalid_price';
    case MissingField = 'missing_field';

    public function label(): string
    {
        return match ($this) {
            self::UnitMismatch => 'مغایرت واحد',
            self::DuplicateCode => 'کد تکراری',
            self::InvalidPrice => 'قیمت نامعتبر',
            self::MissingField => 'فیلد ضروری ناقص',
        };
    }
}
