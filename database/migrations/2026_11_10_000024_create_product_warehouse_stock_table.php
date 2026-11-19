<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * موجودی کالا در انبار
 * فقط سه وضعیت «قابل سفارش، ناموجود، نیازمند به‌روزرسانی» به مشتری نشان داده می‌شود. عدد دقیق فقط برای مدیر شعبه و مدیر مرکزی (خواندنی) است. erp_synced_at «زمان آخرین دریافت» است. «قابل سفارش» تضمین تأمین نیست و رادمان موجودی رزرو نمی‌کند.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_warehouse_stock', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('warehouse_id')->constrained()->cascadeOnDelete();
            $table->string('status', 20)->default('needs_update');
            $table->decimal('quantity', 14, 3)->nullable();
            $table->timestamp('erp_synced_at')->nullable();
            $table->unique(['product_id', 'warehouse_id']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_warehouse_stock');
    }
};
