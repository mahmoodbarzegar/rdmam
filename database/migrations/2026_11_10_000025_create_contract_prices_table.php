<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * قیمت یا تخفیف قراردادی ERP
 * قرارداد معتبر مشتری در ERP. مسیر دوم قیمت‌گذاری است و فقط وقتی کمپینی اعمال نشود استفاده می‌شود. اگر product_id خالی باشد، قرارداد روی همه کالاها یا یک دسته‌بندی کالا اعمال می‌شود.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contract_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('erp_id')->nullable();
            $table->unsignedBigInteger('price')->nullable();               // قیمت قراردادی (ریال)
            $table->decimal('discount_percent', 5, 2)->nullable();         // یا درصد تخفیف قراردادی
            $table->date('valid_from')->nullable();
            $table->date('valid_to')->nullable();
            $table->timestamp('erp_synced_at')->nullable();
            $table->index(['customer_id', 'product_id']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contract_prices');
    }
};
