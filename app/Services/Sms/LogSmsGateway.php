<?php

namespace App\Services\Sms;

use Illuminate\Support\Facades\Log;

/**
 * درگاه پیش‌فرض برای محیط توسعه (local): به‌جای ارسال واقعی پیامک،
 * کد را در لاگ می‌نویسد تا بدون نیاز به پنل پیامکی واقعی قابل تست باشد.
 */
class LogSmsGateway implements SmsGatewayInterface
{
    public function sendOtp(string $mobile, string $code): bool
    {
        Log::info("[OTP-DEV] کد تایید برای {$mobile}: {$code}");
        return true;
    }
}
