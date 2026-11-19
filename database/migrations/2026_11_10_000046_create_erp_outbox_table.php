<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * صف پایدار ارسال به ERP (Outbox)
 * با تأیید مدیر شعبه، ردیف و تأیید در یک تراکنش ثبت می‌شوند، پس ارسال به باز بودن مرورگر وابسته نیست. idempotency_key (شناسه سفارش + نسخه تأییدشده) را ERP برای جلوگیری از ثبت تکراری و استعلام نتیجه استفاده می‌کند. زمان‌بندی تلاش‌ها: ۱، ۵، ۱۵، ۳۰ و ۶۰ دقیقه؛ بعد از پنج تلاش ناموفق وضعیت needs_attention می‌شود و هشدار مرکزی ساخته می‌شود، ولی سفارش حذف یا لغو نمی‌شود. موفقیت فقط با شناسه ERP و نتیجه پذیرش معتبر ثبت می‌شود.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('erp_outbox', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('order_revision_id')->constrained()->cascadeOnDelete();
            $table->string('idempotency_key', 80)->unique();
            $table->json('payload');
            $table->string('status', 20)->default('queued')->index();
            $table->unsignedTinyInteger('attempts')->default(0);
            $table->timestamp('next_attempt_at')->nullable()->index();
            $table->timestamp('last_attempt_at')->nullable();
            $table->text('last_error')->nullable();
            $table->string('erp_order_id')->nullable();
            $table->json('erp_response')->nullable();
            $table->timestamp('succeeded_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('erp_outbox');
    }
};
