<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * اقلام پرداخت (چک یا نقدی)
 * ردیف ۱ چک (شماره، صیاد، بانک، تاریخ سررسید) و ردیف ۲ پرداخت نقدی (شماره رسید). تصویر چک یا رسید در جدول attachments ذخیره می‌شود.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_request_id')->constrained()->cascadeOnDelete();
            $table->string('type', 10);                          // check | cash
            $table->unsignedBigInteger('amount');
            $table->string('check_number', 40)->nullable();
            $table->string('sayad_id', 20)->nullable();
            $table->string('bank_name', 60)->nullable();
            $table->date('due_date')->nullable();
            $table->string('receipt_number', 60)->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->string('status', 10)->default('pending');
            $table->text('reject_reason')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_items');
    }
};
