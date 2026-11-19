<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * اعتبار و بدهی مشتری (فقط خواندنی)
 * نسخه‌ای از اطلاعات اعتباری ERP برای نمایش. رادمان هرگز از اعتبار کم نمی‌کند. مقدار NULL به معنی «اطلاعات در دسترس نیست» است و با صفر یا «تسویه‌شده» فرق دارد.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customer_credit_snapshots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->unique()->constrained()->cascadeOnDelete();
            $table->bigInteger('credit_limit')->nullable();       // ریال
            $table->bigInteger('usable_credit')->nullable();
            $table->bigInteger('total_debt')->nullable();
            $table->json('payment_terms')->nullable();
            $table->boolean('is_available')->default(false);
            $table->timestamp('erp_synced_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_credit_snapshots');
    }
};
