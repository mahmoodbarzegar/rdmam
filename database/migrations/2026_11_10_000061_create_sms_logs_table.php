<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * لاگ پیامک‌ها
 * وضعیت ارسال هر پیامک (ارائه‌دهنده، شناسه پیام، خطا). شامل OTP نمی‌شود و آن‌ها در otp_codes ثبت می‌شوند.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sms_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('mobile', 15)->index();
            $table->string('template', 60);
            $table->text('message');
            $table->string('provider', 30)->nullable();
            $table->string('provider_message_id')->nullable();
            $table->string('status', 15)->default('queued');
            $table->text('error')->nullable();
            $table->nullableMorphs('related');
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sms_logs');
    }
};
