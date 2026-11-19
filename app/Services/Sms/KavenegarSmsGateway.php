<?php

namespace App\Services\Sms;

use Illuminate\Support\Facades\Http;

/**
 * نمونه پیاده‌سازی برای درگاه کاوه‌نگار.
 * برای هر درگاه دیگر (ملی‌پیامک، فراز و ...) کافیست کلاسی مشابه با همین
 * اینترفیس بسازید و در AppServiceProvider بایند کنید. کد بقیه‌ی پروژه بدون تغییر می‌ماند.
 */
class KavenegarSmsGateway implements SmsGatewayInterface
{
    public function __construct(
        protected string $apiKey = '',
        protected string $template = 'verify',
    ) {
        $this->apiKey = config('services.kavenegar.api_key', '');
        $this->template = config('services.kavenegar.otp_template', 'verify');
    }

    public function sendOtp(string $mobile, string $code): bool
    {
        $response = Http::asForm()->post("https://api.kavenegar.com/v1/{$this->apiKey}/verify/lookup.json", [
            'receptor' => $mobile,
            'token' => $code,
            'template' => $this->template,
        ]);

        return $response->successful();
    }
}
