<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * اجرای همگام‌سازی‌ها
 * هر اجرای دریافت کالا، قیمت، موجودی، اعتبار یا فاکتور. «زمان آخرین دریافت» در همه گزارش‌ها و وضعیت‌های «نیازمند به‌روزرسانی» از همین‌جا می‌آید.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('erp_sync_runs', function (Blueprint $table) {
            $table->id();
            $table->string('entity', 30)->index();               // products | prices | stock | credit | invoices | customers
            $table->timestamp('started_at');
            $table->timestamp('finished_at')->nullable();
            $table->string('status', 15);
            $table->unsignedInteger('records_processed')->default(0);
            $table->unsignedInteger('records_failed')->default(0);
            $table->string('cursor')->nullable();
            $table->text('error_message')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('erp_sync_runs');
    }
};
