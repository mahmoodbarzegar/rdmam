<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * کالا و دسته‌بندی کالای مشمول یا مستثنا
 * برای C01 و C02 فهرست مشمول‌ها و برای هر چهار الگو فهرست استثنائات. هر ردیف یا product_id یا category_id دارد.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('campaign_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_version_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('role', 10)->default('eligible');
            $table->unsignedInteger('min_qty')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('campaign_items');
    }
};
