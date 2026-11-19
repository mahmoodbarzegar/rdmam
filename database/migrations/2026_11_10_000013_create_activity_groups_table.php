<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * گروه‌های فعالیت
 * فهرست گروه فعالیت مشتری (مثلاً تعمیرکار، فروشگاه قطعات). مرجع آن ERP یا مدیر مرکزی است.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('erp_code', 50)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_groups');
    }
};
