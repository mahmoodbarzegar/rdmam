<?php

namespace App\Enums;

enum OrderSyncStatus: string
{
    case NotSent = 'not_sent';
    case Queued = 'queued';
    case Sending = 'sending';
    case Unknown = 'unknown';
    case Succeeded = 'succeeded';
    case NeedsAttention = 'needs_attention';

    public function label(): string
    {
        return match ($this) {
            self::NotSent => 'ارسال نشده',
            self::Queued => 'در صف',
            self::Sending => 'در حال ارسال',
            self::Unknown => 'نتیجه نامشخص',
            self::Succeeded => 'موفق',
            self::NeedsAttention => 'خطای نیازمند بررسی',
        };
    }
}
