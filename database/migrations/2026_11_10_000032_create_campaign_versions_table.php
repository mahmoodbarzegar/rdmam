<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * نسخه‌های کمپین (فیلدهای مشترک و اختصاصی)
 * همه فیلدهای فرم کمپین. بخش مشترک برای هر چهار الگو است و فیلدهای اختصاصی هر الگو (C01 تا C04) nullable هستند. نسخه منتشرشده تغییر نمی‌کند و ویرایش یک نسخه جدید می‌سازد.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('campaign_versions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->constrained()->cascadeOnDelete();
            $table->unsignedSmallInteger('version_no');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('incentive_type', 10);                    // percent | fixed | tiered
            $table->decimal('incentive_value', 15, 2)->nullable();   // درصد یا مبلغ ثابت
            $table->dateTime('starts_at');
            $table->dateTime('ends_at');
            $table->unsignedInteger('priority')->default(0);         // عدد کمتر = اولویت بالاتر
            // جامعه هدف (انتخاب‌ها در جداول واسط)
            $table->string('audience_type', 10)->default('all');     // all | selected
            $table->boolean('all_branches')->default(true);
            $table->boolean('all_regions')->default(true);
            // محدودیت‌ها
            $table->unsignedBigInteger('min_order_amount')->nullable();
            $table->unsignedBigInteger('max_discount_per_order')->nullable();
            $table->unsignedInteger('max_uses_per_customer')->nullable();
            $table->unsignedBigInteger('budget_limit')->nullable();
            $table->unsignedInteger('orders_limit')->nullable();
            // C01: کالای خاص
            $table->string('unit_scope', 15)->nullable();            // all_units | limited_units
            $table->unsignedInteger('min_qty')->nullable();
            $table->unsignedInteger('max_discounted_qty')->nullable();
            // C02: خرید حجمی
            $table->string('qty_basis', 15)->nullable();             // per_sku | category_total
            $table->string('discount_on', 15)->nullable();           // all_units | excess_units
            $table->unsignedInteger('max_countable_qty')->nullable();
            // C03: مبلغ سفارش
            $table->string('amount_basis', 15)->nullable();          // cart_total | eligible_items
            $table->unsignedBigInteger('max_eligible_amount')->nullable();
            // C03 و C04
            $table->string('apply_to', 15)->nullable();              // whole_order | eligible_items
            // C04: ترکیبی
            $table->string('conditions_operator', 3)->nullable();    // AND | OR
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->unique(['campaign_id', 'version_no']);
            $table->index(['starts_at', 'ends_at']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('campaign_versions');
    }
};
