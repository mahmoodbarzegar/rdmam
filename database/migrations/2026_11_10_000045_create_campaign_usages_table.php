<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * مصرف کمپین
 * ثبت اینکه هر نسخه سفارش چه مقدار از کمپین مصرف کرده. state سه حالت «تعهد باز، پذیرفته‌شده، فاکتورشده» را برای گزارش جدا نگه می‌دارد. در صورت رد، لغو یا انقضای سفارش، ردیف released می‌شود و بودجه آزاد می‌گردد.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('campaign_usages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->constrained();
            $table->foreignId('campaign_version_id')->constrained();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('order_revision_id')->unique()->constrained()->cascadeOnDelete();
            $table->foreignId('customer_id')->constrained();
            $table->unsignedBigInteger('discount_amount');
            $table->string('state', 10)->default('committed');
            $table->index(['campaign_id', 'state']);
            $table->index(['campaign_id', 'customer_id']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('campaign_usages');
    }
};
