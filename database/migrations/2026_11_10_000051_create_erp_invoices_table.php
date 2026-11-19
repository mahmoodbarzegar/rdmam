<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * فاکتور و مرجوعی دریافتی از ERP
 * پایه فروش قطعی. فروش قطعی فقط با سند معتبر ERP گزارش می‌شود، نه با ثبت یا تأیید. هر فاکتور با erp_id یکتا است و دریافت تکراری امتیاز دوباره نمی‌سازد. net بدون مالیات و حمل و مبنای امتیاز است.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('erp_invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained();
            $table->foreignId('order_id')->nullable()->constrained()->nullOnDelete();
            $table->string('erp_id')->unique();
            $table->string('number', 60)->nullable();
            $table->string('type', 10)->default('sale');           // sale | return
            $table->date('invoice_date');
            $table->unsignedBigInteger('gross')->default(0);
            $table->unsignedBigInteger('discount')->default(0);
            $table->unsignedBigInteger('net')->default(0);         // بدون مالیات و حمل
            $table->unsignedBigInteger('tax')->default(0);
            $table->unsignedBigInteger('shipping')->default(0);
            $table->unsignedBigInteger('total')->default(0);
            $table->string('status', 20)->nullable();
            $table->timestamp('erp_synced_at')->nullable();
            $table->index(['customer_id', 'invoice_date']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('erp_invoices');
    }
};
