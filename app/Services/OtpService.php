<?php

namespace App\Services;

use App\Models\User;
use App\Services\Sms\SmsGatewayInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

/**
 * تمام منطق OTP (تولید، محدودیت ارسال، اعتبارسنجی) یک‌جا اینجا متمرکز است
 * تا هم در ثبت‌نام، هم در ورود، و هم در بازیابی رمز با موبایل قابل استفاده باشد.
 */
class OtpService
{
    protected const CODE_LENGTH = 5;
    protected const EXPIRES_IN_MINUTES = 2;
    protected const RESEND_COOLDOWN_SECONDS = 120;
    protected const MAX_ATTEMPTS = 5;

    public function __construct(protected SmsGatewayInterface $smsGateway)
    {
    }

    protected function cooldownKey(string $mobile): string
    {
        return "otp_cooldown:{$mobile}";
    }

    protected function attemptsKey(string $mobile): string
    {
        return "otp_attempts:{$mobile}";
    }

    // چند ثانیه تا مجاز بودن ارسال مجدد کد باقی مانده (برای نمایش تایمر شمارش معکوس در UI)
    public function secondsUntilResend(string $mobile): int
    {
        $remaining = Cache::get($this->cooldownKey($mobile));
        return $remaining ? max(0, $remaining - now()->timestamp) : 0;
    }

    public function generateAndSend(string $mobile): array
    {
        if ($this->secondsUntilResend($mobile) > 0) {
            return ['success' => false, 'message' => 'لطفاً کمی صبر کنید و دوباره تلاش کنید.'];
        }

        $code = (string)random_int(10000, 99999); // کد ۵ رقمی

        $user = User::where('mobile', $mobile)->first();

        if ($user) {

            $user->update([
                'otp_code' => Hash::make($code),
                'otp_expires_at' => now()->addMinutes(self::EXPIRES_IN_MINUTES),
            ]);

        } else {
            // برای ثبت‌نام: کد را به‌صورت موقت در کش نگه می‌داریم تا کاربر هنوز ساخته نشده
            Cache::put("otp_pending:{$mobile}", Hash::make($code), now()->addMinutes(self::EXPIRES_IN_MINUTES));
        }

        Cache::put($this->cooldownKey($mobile), now()->timestamp + self::RESEND_COOLDOWN_SECONDS, self::RESEND_COOLDOWN_SECONDS);
        Cache::forget($this->attemptsKey($mobile));

        $sent = $this->smsGateway->sendOtp($mobile, $code);

        return $sent
            ? ['success' => true, 'message' => "کد تایید به شماره {$mobile} ارسال شد."]
            : ['success' => false, 'message' => 'ارسال پیامک ناموفق بود. دوباره تلاش کنید.'];
    }

    public function verify(string $mobile, string $code): array
    {
        $attempts = Cache::get($this->attemptsKey($mobile), 0);
        if ($attempts >= self::MAX_ATTEMPTS) {
            return ['success' => false, 'message' => 'تعداد تلاش‌های شما بیش از حد مجاز است. کد جدید دریافت کنید.'];
        }

        $user = User::where('mobile', $mobile)->first();

        // حالت ۱: کاربر از قبل وجود دارد (ورود یا بازیابی رمز)
        if ($user) {
            if (!$user->otp_expires_at || now()->gt($user->otp_expires_at)) {
                return ['success' => false, 'message' => 'کد منقضی شده است.'];
            }
            if (!Hash::check($code, $user->otp_code)) {
                Cache::increment($this->attemptsKey($mobile));
                return ['success' => false, 'message' => 'کد وارد شده صحیح نیست.'];
            }

            $user->update(['otp_code' => null, 'otp_expires_at' => null, 'mobile_verified_at' => $user->mobile_verified_at ?? now()]);
            Cache::forget($this->attemptsKey($mobile));

            return ['success' => true, 'message' => 'تایید شد.', 'user' => $user];
        }

        // حالت ۲: ثبت‌نام (کاربر هنوز ساخته نشده)
        $pendingHash = Cache::get("otp_pending:{$mobile}");
        if (!$pendingHash) {
            return ['success' => false, 'message' => 'کد منقضی شده است.'];
        }
        if (!Hash::check($code, $pendingHash)) {
            Cache::increment($this->attemptsKey($mobile));
            return ['success' => false, 'message' => 'کد وارد شده صحیح نیست.'];
        }

        Cache::forget("otp_pending:{$mobile}");
        Cache::forget($this->attemptsKey($mobile));

        return ['success' => true, 'message' => 'تایید شد.', 'user' => null];
    }
}
