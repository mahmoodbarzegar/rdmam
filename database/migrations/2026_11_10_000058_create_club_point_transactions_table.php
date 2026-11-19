<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * دفتر امتیاز (Ledger)
 * هر تغییر امتیاز یک ردیف است (کسب، برگشت، انقضا، اصلاح دستی با دلیل، تشویقی). مقدار points علامت‌دار است. برای انقضای FIFO، remaining_points در ردیف‌های کسب مصرف یا منقضی می‌شود. unique روی (فاکتور، نوع) از امتیاز تکراری برای دریافت دوباره فاکتور جلوگیری می‌کند.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('club_point_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->string('type', 10);                          // earn | reverse | expire | adjust | bonus
            $table->decimal('points', 14, 2);                    // مثبت یا منفی
            $table->decimal('remaining_points', 14, 2)->default(0);
            $table->foreignId('order_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('erp_invoice_id')->nullable()->constrained()->nullOnDelete();
            $table->date('expires_at')->nullable()->index();
            $table->text('reason')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->unique(['erp_invoice_id', 'type']);
            $table->index(['customer_id', 'created_at']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('club_point_transactions');
    }
};
