<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * پروفایل مدیر شعبه
 * اطلاعات اختصاصی مدیر شعبه (کد ملی، کد پرسنلی، سمت). شعبه‌ی مدیر در این جدول نیست و از جدول سوابق تخصیص (branch_manager_assignments) خوانده می‌شود تا تغییر مدیر و سوابق قبلی درست نگه‌داری شود.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('branch_admins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('national_id', 20)->nullable()->unique();
            $table->string('personnel_code', 30)->nullable();
            $table->string('title', 80)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('branch_admins');
    }
};
