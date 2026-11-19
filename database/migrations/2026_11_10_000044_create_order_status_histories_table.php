<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * تاریخچه وضعیت‌ها
 * تاریخچه هر سه کانال (تجاری، فنی و ERP) با منبع تغییر. erp_event_id برای شناسایی رویداد تکراری یا قدیمی است.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_status_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->string('channel', 10);                       // business | technical | erp
            $table->string('from_status', 30)->nullable();
            $table->string('to_status', 30);
            $table->string('source', 10);                        // user | system | erp
            $table->foreignId('actor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('erp_event_id')->nullable();
            $table->text('note')->nullable();
            $table->timestamp('occurred_at');
            $table->index(['order_id', 'occurred_at']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_status_histories');
    }
};
