<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * لاگ تلاش‌های ارسال
 * سابقه هر تلاش (کد پاسخ، مدت، نتیجه). نتیجه timeout یا unknown به معنی نرسیدن سفارش نیست؛ پیش از تکرار ابتدا استعلام انجام می‌شود.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('erp_outbox_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('outbox_id')->constrained('erp_outbox')->cascadeOnDelete();
            $table->unsignedTinyInteger('attempt_no');
            $table->unsignedSmallInteger('http_status')->nullable();
            $table->string('outcome', 15);                       // success | failed | timeout | unknown
            $table->text('response_body')->nullable();
            $table->unsignedInteger('duration_ms')->nullable();
            $table->timestamp('started_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('erp_outbox_attempts');
    }
};
