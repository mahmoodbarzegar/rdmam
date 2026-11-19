<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * امتیاز محاسبه‌شده هر سفارش
 * امتیاز بر اساس جمع خالص کل سفارش محاسبه می‌شود، نه تک‌تک فاکتورها. مثال سند: ۱۲٫۵ میلیون خالص ← ۱۲٫۵ امتیاز؛ با ۲ میلیون مرجوعی ← ۱۰٫۵ و ۲ امتیاز کسر. این جدول مقدار فعلی را نگه می‌دارد و تفاضل در دفتر امتیاز ثبت می‌شود.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('club_order_points', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->unique()->constrained()->cascadeOnDelete();
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->bigInteger('net_sales')->default(0);
            $table->decimal('points', 14, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('club_order_points');
    }
};
