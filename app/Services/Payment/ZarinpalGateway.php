<?php

namespace App\Services\Payment;

use App\Models\Order;
use Illuminate\Support\Facades\Http;

class ZarinpalGateway implements PaymentGatewayInterface
{
    protected string $merchantId;
    protected string $baseUrl;
    protected string $startPayUrl;

    public function __construct()
    {
        $this->merchantId = config('services.zarinpal.merchant_id', '');
        $sandbox = config('services.zarinpal.sandbox', true);
        $this->baseUrl = $sandbox
            ? 'https://sandbox.zarinpal.com/pg/v4/payment/'
            : 'https://payment.zarinpal.com/pg/v4/payment/';
        $this->startPayUrl = $sandbox
            ? 'https://sandbox.zarinpal.com/pg/StartPay/'
            : 'https://payment.zarinpal.com/pg/StartPay/';
    }

    public function request(Order $order, ?string $callbackUrl = null): array
    {
        // مبلغ زرین‌پال باید بر حسب تومان ارسال شود (پروژه‌ی ما هم مبنایش تومان است)
        $response = Http::post($this->baseUrl.'request.json', [
            'merchant_id' => $this->merchantId,
            'amount' => $order->total_amount,
            'callback_url' => $callbackUrl ?? route('payment.callback', ['gateway' => 'zarinpal']),
            'description' => "پرداخت سفارش {$order->order_number}",
            'metadata' => ['order_id' => $order->id],
        ]);

        $data = $response->json('data');

        if ($response->successful() && ($data['code'] ?? null) === 100) {
            return [
                'success' => true,
                'authority' => $data['authority'],
                'redirect_url' => $this->startPayUrl.$data['authority'],
            ];
        }

        return ['success' => false, 'message' => $response->json('errors.message', 'خطا در اتصال به درگاه پرداخت.')];
    }

    public function verify(string $authority, int $amount): array
    {
        $response = Http::post($this->baseUrl.'verify.json', [
            'merchant_id' => $this->merchantId,
            'amount' => $amount,
            'authority' => $authority,
        ]);

        $data = $response->json('data');

        if ($response->successful() && in_array($data['code'] ?? null, [100, 101])) {
            return ['success' => true, 'ref_id' => (string) $data['ref_id']];
        }

        return ['success' => false, 'message' => 'پرداخت ناموفق بود یا قبلاً تایید شده است.'];
    }
}
