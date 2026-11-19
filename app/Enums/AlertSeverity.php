<?php

namespace App\Enums;

enum AlertSeverity: string
{
    case Info = 'info';
    case Warning = 'warning';
    case Critical = 'critical';

    public function label(): string
    {
        return match ($this) {
            self::Info => 'اطلاع',
            self::Warning => 'هشدار',
            self::Critical => 'بحرانی',
        };
    }
}
