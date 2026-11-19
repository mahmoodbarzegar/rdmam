<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * خرید خالص روزانه مشتری
 * ورودی فرمول سطح‌بندی: جمع روزهای t-89 تا t. با دریافت هر فاکتور یا مرجوعی، مبلغ روز مربوطه به‌روز می‌شود (مرجوعی منفی). محاسبه سطح با یک SUM ساده روی ۹۰ ردیف انجام می‌شود.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customer_daily_net_sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->date('sales_date');
            $table->bigInteger('net_amount')->default(0);
            $table->unique(['customer_id', 'sales_date']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_daily_net_sales');
    }
};
