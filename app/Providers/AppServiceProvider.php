<?php

namespace App\Providers;

use App\Services\Payment\FakePaymentGateway;
use App\Services\Payment\PaymentGatewayInterface;
use App\Services\Payment\ZarinpalGateway;
use App\Services\Sms\KavenegarSmsGateway;
use App\Services\Sms\LogSmsGateway;
use App\Services\Sms\SmsGatewayInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // تعویض درگاه پیامک فقط با تغییر این خط انجام می‌شود؛
        // در محیط local از LogSmsGateway (ثبت کد در لاگ) استفاده می‌شود.
        $this->app->bind(SmsGatewayInterface::class, function () {
            return $this->app->environment('production')
                ? new KavenegarSmsGateway()
                : new LogSmsGateway();
        });

        // تعویض درگاه پرداخت هم به همین شکل؛ برای افزودن درگاه جدید
        // (آیدی‌پی، به‌پرداخت ملت و ...) فقط یک کلاس مطابق PaymentGatewayInterface
        // بسازید و اینجا بایند کنید — بقیه‌ی پروژه دست‌نخورده می‌ماند.
        $this->app->bind(PaymentGatewayInterface::class, function () {
            return $this->app->environment('production')
                ? new ZarinpalGateway()
                : new FakePaymentGateway();
        });



        $this->app->singleton(\App\Services\PartyManagementService::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
