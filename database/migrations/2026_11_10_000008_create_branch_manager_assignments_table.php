<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * سوابق مدیر شعبه
 * قاعده «هر شعبه فقط یک مدیر فعال» و «سوابق مدیر قبلی می‌ماند». با تغییر مدیر، ردیف قبلی با ended_at بسته می‌شود. ستون active_branch_id فقط وقتی ردیف فعال است مقدار دارد و unique است، پس دیتابیس خودش از دو مدیر فعال جلوگیری می‌کند. هنگام تغییر مدیر، توکن‌های قبلی در لایه احراز هویت باطل می‌شود.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('branch_manager_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->constrained()->cascadeOnDelete();
            $table->foreignId('branch_manager_id')->constrained('branch_managers')->cascadeOnDelete();
            $table->timestamp('started_at');
            $table->timestamp('ended_at')->nullable();
            $table->string('ended_reason')->nullable();
            // برابر branch_id وقتی فعال است و NULL وقتی بسته شده؛ unique روی NULL چندگانه مجاز است
            $table->unsignedBigInteger('active_branch_id')->nullable()->unique();
            $table->foreignId('assigned_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('branch_manager_assignments');
    }
};
