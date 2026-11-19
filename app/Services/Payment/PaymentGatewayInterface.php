<?php

namespace App\Services\Payment;

use App\Models\Order;

/**
 * قرارداد یکسان برای همه‌ی درگاه‌های پرداخت (زرین‌پال، آیدی‌پی، به‌پرداخت ملت و ...)
 * تا تعویض درگاه فقط با تغییر Binding در Service Provider انجام شود.
 */
interface PaymentGatewayInterface
{
    /**
     * شروع تراکنش و دریافت لینک انتقال کاربر به درگاه.
     * $callbackUrl در حالت پیش‌فرض null است و به معنی «استفاده از callback استاندارد سفارش» است؛
     * برای مصارف دیگر (مثل شارژ کیف پول) یک callback route اختصاصی پاس داده می‌شود.
     * @return array{success: bool, authority?: string, redirect_url?: string, message?: string}
     */
    public function request(Order $order, ?string $callbackUrl = null): array;

    /**
     * تایید نهایی تراکنش بعد از بازگشت کاربر از درگاه (Callback).
     * @return array{success: bool, ref_id?: string, message?: string}
     */
    public function verify(string $authority, int $amount): array;
}
