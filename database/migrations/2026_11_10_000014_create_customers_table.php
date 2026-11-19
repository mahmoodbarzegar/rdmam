<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * مشتریان
 * پرونده تجاری مشتری (نام، موبایل و ایمیل در users است). خرید فقط با erp_id فعال ممکن است. وضعیت حساب و «محدودیت اعتباری» دو چیز جدا هستند: credit_restricted یعنی تاریخچه دیده می‌شود ولی سفارش اعتباری ثبت نمی‌شود، و مسدودی با status=blocked انجام می‌شود.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('erp_id')->nullable()->unique();
            $table->string('erp_code')->nullable()->unique();
            $table->string('business_name')->nullable();             // نام تجاری/شرکت؛ نام و موبایل در users است
            $table->string('phone', 20);              // شماره تلفن
            $table->string('national_code', 20)->index();              // کد ملی یا شناسه ملی
            $table->json('company_info')->nullable();                // اطلاعات شرکت طبق الزام ERP
            $table->foreignId('province_id')->constrained();
            $table->foreignId('city_id')->constrained();
            $table->string('path_id')->nullable();
            $table->string('postal_code', 10)->nullable();
            $table->foreignId('branch_id')->constrained();
            $table->string('status', 20)->default('pending_review');
            $table->string('credit')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->text('status_reason')->nullable();
            $table->timestamp('erp_synced_at')->nullable();
            $table->index(['branch_id', 'status','path_id']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
