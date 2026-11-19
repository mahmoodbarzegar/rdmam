<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * سطح‌های باشگاه مشمول کمپین
 * مزیت مالی هر سطح باشگاه از همین مسیر داده می‌شود و تابع قاعده «یک کمپین، بدون تخفیف مضاعف» است.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('campaign_club_levels', function (Blueprint $table) {
            $table->foreignId('campaign_version_id')->constrained()->cascadeOnDelete();
            $table->foreignId('club_level_id')->constrained()->cascadeOnDelete();
            $table->primary(['campaign_version_id', 'club_level_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('campaign_club_levels');
    }
};
