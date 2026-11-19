<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * درخواست پرداخت سفارش
 * یک ردیف برای هر سفارش، که با API ERP ساخته می‌شود. terms شرح شرایط پرداخت و ردیف‌بندی مدل‌های پرداخت است. در صورت عدم تأیید، دلیل مکتوب در rejection_reason نمایش داده می‌شود و ویرایش اسناد دوباره باز می‌شود.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('erp_payment_id')->nullable();
            $table->json('terms')->nullable();
            $table->unsignedBigInteger('total_due')->nullable();
            $table->string('status', 20)->default('awaiting_customer')->index();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_requests');
    }
};
