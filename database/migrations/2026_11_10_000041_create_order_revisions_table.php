<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * نسخه‌های سفارش (قیمت‌گذاری و Snapshot)
 * هر ثبت یا اصلاح یک نسخه کامل است و تخفیف نسخه قبلی منتقل نمی‌شود. مبالغ، سیاست قیمت‌گذاری (فقط یک مسیر)، شناسه و نسخه کمپین در همین‌جا ثبت می‌شوند. نسخه تأییدشده با locked_at قفل می‌شود و همان نسخه به ERP می‌رود.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_revisions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->unsignedSmallInteger('revision_no');
            $table->string('status', 15)->default('pending');
            $table->string('pricing_policy', 10);                         // campaign | contract | base
            $table->foreignId('campaign_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('campaign_version_id')->nullable()->constrained()->nullOnDelete();
            $table->string('campaign_title')->nullable();                 // Snapshot نام کمپین
            $table->boolean('contract_discount_removed')->default(false); // برای نمایش پیام در بازبینی
            $table->unsignedBigInteger('gross_total')->default(0);        // همه مبالغ به ریال صحیح
            $table->unsignedBigInteger('discount_total')->default(0);
            $table->unsignedBigInteger('net_total')->default(0);
            $table->unsignedBigInteger('tax_total')->default(0);
            $table->unsignedBigInteger('payable_total')->default(0);
            $table->timestamp('priced_at')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('locked_at')->nullable();
            $table->text('note')->nullable();
            $table->unique(['order_id', 'revision_no']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_revisions');
    }
};
