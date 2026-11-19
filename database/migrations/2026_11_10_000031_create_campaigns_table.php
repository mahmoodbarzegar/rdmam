<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * کمپین‌ها (هویت و شمارنده‌ها)
 * هویت ثابت کمپین: کد یکتا، الگو و وضعیت. تمام قواعد در نسخه‌ها هستند. budget_used و orders_used با UPDATE اتمیک افزایش می‌یابند. با رسیدن به سقف بودجه، auto_paused_at ثبت و کمپین خودکار متوقف می‌شود.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('code', 40)->unique();
            $table->string('type', 3);                              // C01..C04؛ پس از ساخت تغییر نمی‌کند
            $table->string('status', 10)->default('draft')->index();
            $table->unsignedBigInteger('current_version_id')->nullable();   // FK در مایگریشن آخر اضافه می‌شود
            $table->unsignedBigInteger('budget_used')->default(0);
            $table->unsignedInteger('orders_used')->default(0);
            $table->timestamp('auto_paused_at')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};
