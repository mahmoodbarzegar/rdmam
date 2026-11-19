<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * تنظیمات سراسری
 * جدول کلید/مقدار برای پارامترهای مدیر مرکزی، مثل min_order_amount، approval_deadline_hours (۴۸)، cart_ttl_days (۷)، cart_max_rows (۱۰۰) و ساعت‌های یادآوری (۲۴ و ۴۴). این‌ها در کد ثابت نمی‌شوند.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('system_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key', 100)->unique();
            $table->json('value');
            $table->string('description')->nullable();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('system_settings');
    }
};
