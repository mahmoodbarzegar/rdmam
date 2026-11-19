<?php

namespace App\Services\Payment;

use App\Models\Order;
use Illuminate\Support\Str;

/**
 * درگاه شبیه‌سازی‌شده برای محیط توسعه (local): بدون تماس با سرویس خارجی،
 * کاربر را مستقیم به صفحه‌ی تاییدیه‌ی داخلی می‌فرستد تا کل مسیر Checkout
 * قابل تست باشد بدون نیاز به merchant_id واقعی.
 */
class FakePaymentGateway implements PaymentGatewayInterface
{
    public function request(Order $order, ?string $callbackUrl = null): array
    {
        $authority = 'FAKE-'.Str::upper(Str::random(20));

        return [
            'success' => true,
            'authority' => $authority,
            'redirect_url' => route('payment.fake', ['authority' => $authority, 'callback' => $callbackUrl]),
        ];
    }

    public function verify(string $authority, int $amount): array
    {
        // در محیط توسعه همیشه موفق فرض می‌شود
        return ['success' => true, 'ref_id' => 'FAKE-REF-'.random_int(100000, 999999)];
    }
}
