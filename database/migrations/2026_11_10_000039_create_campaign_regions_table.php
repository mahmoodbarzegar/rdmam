<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * مناطق جغرافیایی مشمول کمپین
 * وقتی all_regions=false است، استان و شهر (اختیاری) مشمول را از جدول‌های provinces و cities مشخص می‌کند. city_id خالی یعنی کل استان.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('campaign_regions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_version_id')->constrained()->cascadeOnDelete();
            $table->foreignId('province_id')->constrained()->cascadeOnDelete();
            $table->foreignId('city_id')->nullable()->constrained()->cascadeOnDelete();   // خالی یعنی کل استان
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('campaign_regions');
    }
};
