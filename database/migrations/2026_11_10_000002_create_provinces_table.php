<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * استان‌ها
 * فهرست استان‌ها به‌صورت جدول مرجع. به‌جای ذخیره نام استان به‌صورت متن آزاد، شعبه، مشتری و منطقه کمپین با province_id به این جدول وصل می‌شوند. erp_code برای نگاشت با کد استان در ERP است.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('provinces', function (Blueprint $table) {
            $table->id();
            $table->string('name', 60)->unique();
            $table->string('erp_code', 30)->nullable()->unique();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('provinces');
    }
};
