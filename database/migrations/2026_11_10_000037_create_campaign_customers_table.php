<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * مشتریان منتخب کمپین
 * وقتی audience_type=selected است، فقط این مشتریان مشمول‌اند.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('campaign_customers', function (Blueprint $table) {
            $table->foreignId('campaign_version_id')->constrained()->cascadeOnDelete();
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->primary(['campaign_version_id', 'customer_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('campaign_customers');
    }
};
