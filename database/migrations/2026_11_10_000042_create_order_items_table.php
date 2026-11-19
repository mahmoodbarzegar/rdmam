<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * ردیف‌های سفارش
 * هر ردیف همه اجزای محاسبه را دارد: ناخالص، تخفیف، خالص، مالیات و جمع. کد و عنوان کالا هم کپی می‌شود تا تغییر بعدی کاتالوگ سفارش قدیمی را عوض نکند. تخفیف کمپین بین ردیف‌ها به نسبت مبلغ مشمول تقسیم می‌شود و جمع ردیف‌ها دقیقاً با کل تخفیف برابر است.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_revision_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained();
            $table->string('product_code', 60);
            $table->string('product_title');
            $table->string('unit', 10);
            $table->unsignedInteger('quantity_input');
            $table->unsignedInteger('quantity_base');
            $table->decimal('sales_factor', 12, 4)->default(1);
            $table->unsignedBigInteger('base_price');
            $table->unsignedBigInteger('contract_price')->nullable();
            $table->unsignedBigInteger('gross_amount');
            $table->unsignedBigInteger('discount_amount')->default(0);
            $table->unsignedBigInteger('net_amount');
            $table->decimal('tax_rate', 5, 2)->default(0);
            $table->unsignedBigInteger('tax_amount')->default(0);
            $table->unsignedBigInteger('total_amount');
            $table->string('discount_source', 10)->default('base');
            $table->boolean('campaign_eligible')->default(true);          // کالای مستثنا از کمپین false است
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
