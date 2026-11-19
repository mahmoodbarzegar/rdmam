<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * لاگ خروجی گزارش‌ها
 * هر خروجی Excel یا CSV با فیلترها و محدوده دسترسی کاربر ثبت می‌شود. فایل خروجی مدیر شعبه فقط شامل شعبه خودش است.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('report_exports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('report_key', 40);
            $table->json('filters')->nullable();
            $table->string('format', 5);                         // xlsx | csv
            $table->string('status', 12)->default('queued');
            $table->string('file_path')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('report_exports');
    }
};
