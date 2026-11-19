<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * شعب مشمول کمپین
 * وقتی all_branches=false است، فقط شعب این جدول مشمول‌اند.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('campaign_branches', function (Blueprint $table) {
            $table->foreignId('campaign_version_id')->constrained()->cascadeOnDelete();
            $table->foreignId('branch_id')->constrained()->cascadeOnDelete();
            $table->primary(['campaign_version_id', 'branch_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('campaign_branches');
    }
};
