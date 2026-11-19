<?php

namespace App\Services\Sms;

/**
 * قرارداد یکسان برای همه‌ی درگاه‌های پیامک (کاوه‌نگار، ملی‌پیامک، فراز اس‌ام‌اس و ...)
 * تا تعویض درگاه فقط با تغییر Binding در Service Provider انجام شود، نه تغییر کد.
 */
interface SmsGatewayInterface
{
    public function sendOtp(string $mobile, string $code): bool;
}
