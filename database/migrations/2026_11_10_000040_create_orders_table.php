<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * سفارش‌ها (سربرگ)
 * business_status و sync_status عمداً جدا هستند تا خطای شبکه سفارش پذیرفته‌شده را به مرحله اول برنگرداند. current_revision_id نسخه جاری است و approved_revision_id نسخه تأییدشده و قفل‌شده. deadline_at برابر ۴۸ ساعت از ثبت است و با درخواست اصلاح تمدید نمی‌شود. وضعیت‌های بعد از ورود به ERP (erp_status) فقط از رویدادهای ERP پر می‌شوند، هرگز از حدس یا فاصله زمانی.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('number', 25)->unique();
            $table->foreignId('customer_id')->constrained();
            $table->foreignId('branch_id')->constrained();
            $table->foreignId('warehouse_id')->constrained();
            $table->string('business_status', 25)->default('draft')->index();
            $table->string('sync_status', 25)->default('not_sent')->index();
            $table->unsignedBigInteger('current_revision_id')->nullable();    // FK در مایگریشن آخر
            $table->unsignedBigInteger('approved_revision_id')->nullable();
            $table->json('payment_terms')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('deadline_at')->nullable()->index();            // ثبت + ۴۸ ساعت
            $table->timestamp('correction_requested_at')->nullable();
            $table->timestamp('correction_deadline_at')->nullable();          // حداکثر ۲۴ ساعت و تا پایان deadline_at
            $table->timestamp('reminder_24_sent_at')->nullable();
            $table->timestamp('reminder_44_sent_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->text('close_reason')->nullable();
            $table->foreignId('cancelled_by')->nullable()->constrained('users')->nullOnDelete();
            // اطلاعات برگشتی از ERP
            $table->string('erp_id')->nullable()->unique();
            $table->string('erp_order_number', 60)->nullable();
            $table->string('erp_status', 30)->nullable();                     // processing | invoiced | shipped | delivered | cancelled
            $table->timestamp('erp_status_at')->nullable();
            $table->timestamp('erp_accepted_at')->nullable();
            $table->index(['branch_id', 'business_status']);
            $table->index(['customer_id', 'business_status']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
