<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * شروط کمپین ترکیبی (C04)
 * هر شرط مستقل است (تعداد کالا، تعداد دسته‌بندی یا مبلغ سبد) و با conditions_operator نسخه (AND یا OR) ترکیب می‌شوند.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('campaign_conditions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_version_id')->constrained()->cascadeOnDelete();
            $table->string('condition_type', 15);                    // product_qty | category_qty | cart_amount
            $table->foreignId('product_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->nullable()->constrained()->cascadeOnDelete();
            $table->unsignedInteger('min_qty')->nullable();
            $table->unsignedBigInteger('min_amount')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('campaign_conditions');
    }
};
