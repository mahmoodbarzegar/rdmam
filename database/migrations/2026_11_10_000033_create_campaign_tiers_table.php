<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * پله‌های تخفیف
 * پله‌ها برای C02 بر اساس تعداد و برای C03 بر اساس مبلغ هستند (مثل ۱۰ تا ۱۹ عدد ← ۳٪). to_value خالی یعنی «به بالا». value درصد یا مبلغ تخفیف پله است.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('campaign_tiers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_version_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('from_value');
            $table->unsignedBigInteger('to_value')->nullable();
            $table->decimal('value', 15, 2);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('campaign_tiers');
    }
};
