<?php

namespace App\Enums;

enum HistoryChannel: string
{
    case Business = 'business';
    case Technical = 'technical';
    case Erp = 'erp';

    public function label(): string
    {
        return match ($this) {
            self::Business => 'وضعیت تجاری',
            self::Technical => 'وضعیت فنی ارسال',
            self::Erp => 'وضعیت ERP',
        };
    }
}
