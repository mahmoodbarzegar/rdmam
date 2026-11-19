<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * رمزهای یک‌بارمصرف پیامکی
 * ورود، تأیید شماره جدید و عضویت. فقط هش کد ذخیره می‌شود. شمارنده تلاش ناموفق و تاریخ مصرف برای جلوگیری از حدس‌زدن و استفاده مجدد است.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('otp_codes', function (Blueprint $table) {
            $table->id();
            $table->string('mobile', 15)->index();
            $table->string('purpose', 20);                   // login | change_mobile | signup
            $table->string('code_hash');
            $table->timestamp('expires_at');
            $table->unsignedTinyInteger('attempts')->default(0);
            $table->timestamp('consumed_at')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('otp_codes');
    }
};
