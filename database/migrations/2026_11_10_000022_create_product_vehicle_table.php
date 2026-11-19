<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * جدول واسط کالا و خودرو
 * رابطه چندبه‌چند کالا و خودرو.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_vehicle', function (Blueprint $table) {
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('vehicle_id')->constrained()->cascadeOnDelete();
            $table->primary(['product_id', 'vehicle_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_vehicle');
    }
};
