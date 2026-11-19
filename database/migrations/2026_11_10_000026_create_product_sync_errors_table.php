<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * فهرست خطاهای مرکزی کالا
 * مغایرت واحد، کد تکراری یا نبود قیمت معتبر، کالا را از سفارش بازمی‌دارد و به این فهرست می‌رود تا مدیر مرکزی پیگیری کند.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_sync_errors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->string('erp_id')->nullable();
            $table->string('error_type', 30);
            $table->text('message');
            $table->json('payload')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->foreignId('resolved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->index(['error_type', 'resolved_at']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_sync_errors');
    }
};
