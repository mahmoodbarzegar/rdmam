<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * رویدادهای دریافتی از ERP (Inbox)
 * هر رویداد وضعیت یا فاکتور با event_id یکتا ثبت می‌شود تا دوباره پردازش نشود. رویداد قدیمی‌تر از وضعیت فعلی نادیده گرفته می‌شود (ignored_stale) و رویداد ناشناخته به صف بررسی می‌رود (needs_review).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('erp_inbound_events', function (Blueprint $table) {
            $table->id();
            $table->string('event_id')->unique();
            $table->foreignId('order_id')->nullable()->constrained()->nullOnDelete();
            $table->string('event_type', 40);
            $table->json('payload');
            $table->timestamp('occurred_at');
            $table->timestamp('processed_at')->nullable();
            $table->string('outcome', 15)->nullable();           // applied | ignored_stale | needs_review
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('erp_inbound_events');
    }
};
