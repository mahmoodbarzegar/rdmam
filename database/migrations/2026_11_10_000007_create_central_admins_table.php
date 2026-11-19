<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * پروفایل مدیر مرکزی
 * اطلاعات اختصاصی مدیر مرکزی. رمز و احراز هویت دومرحله‌ای چون به ورود مربوط‌اند در users مانده‌اند. اگر بعداً سطح‌های دسترسی مدیران مرکزی مختلف شد، ستون‌های آن اینجا یا در جدول نقش/دسترسی اضافه می‌شود.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('central_admins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('national_id', 20)->nullable()->unique();
            $table->string('personnel_code', 30)->nullable();
            $table->string('title', 80)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('central_admins');
    }
};
