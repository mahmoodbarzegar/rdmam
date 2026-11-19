<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * هشدارهای مرکزی
 * هشدار برای مدیر مرکزی: توقف ارسال بعد از پنج تلاش، خطای همگام‌سازی، رویداد ناشناخته ERP. با morph به هر رکوردی وصل می‌شود.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('central_alerts', function (Blueprint $table) {
            $table->id();
            $table->string('type', 40)->index();
            $table->string('severity', 10)->default('warning');
            $table->string('title');
            $table->text('body')->nullable();
            $table->nullableMorphs('related');
            $table->timestamp('resolved_at')->nullable();
            $table->foreignId('resolved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('central_alerts');
    }
};
