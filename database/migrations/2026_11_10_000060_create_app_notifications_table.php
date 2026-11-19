<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * اعلان‌های داخل پنل
 * اعلان قابل‌خواندن برای هر کاربر. is_important برای رویدادهایی است که پیامک هم می‌گیرند. اخبار عادی وضعیت فقط داخل پنل می‌مانند.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('app_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('type', 40);
            $table->string('title');
            $table->text('body')->nullable();
            $table->json('data')->nullable();
            $table->boolean('is_important')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->index(['user_id', 'read_at']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('app_notifications');
    }
};
