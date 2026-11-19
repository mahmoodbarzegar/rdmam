<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * کاربران (هر سه نقش)
 * هویت و ورود هر سه نقش: نام، موبایل، ایمیل و role. اطلاعات اختصاصی هر نقش در جدول پروفایل خودش است (customers، branch_managers، central_admins) و با user_id به این جدول وصل می‌شود. مشتری و مدیر شعبه با OTP وارد می‌شوند و password ندارند؛ مدیر مرکزی رمز و احراز هویت دومرحله‌ای دارد.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('mobile', 15)->unique();
            $table->string('email')->nullable()->unique();
//            $table->string('role', 20)->index();             // customer | branch_manager | central_admin
            $table->string('status', 15)->default('active');
            $table->string('password')->nullable();          // فقط مدیر مرکزی
            $table->text('otp_code')->nullable();   // احراز هویت تقویت‌شده مدیر مرکزی
            $table->timestamp('otp_expires_at')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
