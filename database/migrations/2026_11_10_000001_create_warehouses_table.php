<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * انبارهای ERP
 * انبار مرجع در ERP. رادمان فقط نسخه‌ای از آن را نگه می‌دارد. یک انبار می‌تواند چند شعبه را پوشش دهد.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('warehouses', function (Blueprint $table) {
            $table->id();
            $table->string('erp_id')->unique();            // شناسه انبار در ERP
            $table->string('erp_code')->nullable();
            $table->string('name');
            $table->boolean('is_active')->default(true);
            $table->timestamp('erp_synced_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('warehouses');
    }
};
