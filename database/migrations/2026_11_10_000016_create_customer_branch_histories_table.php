<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * سابقه انتقال بین شعبه‌ها
 * سفارش‌های قبلی در شعبه قبلی می‌مانند و سفارش منتظر تأیید جابه‌جا نمی‌شود. این جدول فقط سابقه انتقال را نگه می‌دارد.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customer_branch_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->foreignId('from_branch_id')->nullable()->constrained('branches')->nullOnDelete();
            $table->foreignId('to_branch_id')->constrained('branches');
            $table->foreignId('changed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('reason')->nullable();
            $table->timestamp('effective_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_branch_histories');
    }
};
