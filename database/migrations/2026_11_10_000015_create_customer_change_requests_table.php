<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * درخواست‌های تغییر اطلاعات
 * تغییر موبایل با تأیید شماره جدید اعمال می‌شود (روی users.mobile). تغییر اطلاعات رسمی، نشانی و شعبه فقط پس از تأیید مرکزی و تطبیق با ERP اعمال می‌شود. مقدار قبل و بعد در JSON نگه‌داری می‌شود.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customer_change_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->string('type', 20);
            $table->json('old_values');
            $table->json('new_values');
            $table->string('status', 15)->default('pending');
            $table->boolean('erp_matched')->default(false);
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();
            $table->text('review_note')->nullable();
            $table->index(['status', 'type']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_change_requests');
    }
};
