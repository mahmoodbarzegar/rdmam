<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * فایل‌های پیوست (چندریختی)
 * یک جدول برای همه فایل‌ها: تصویر چک، رسید پرداخت، مدرک کسب‌وکار. با morph به هر رکوردی وصل می‌شود. دسترسی به فایل باید از طریق کنترلر و Policy انجام شود، نه لینک عمومی.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            $table->morphs('attachable');
            $table->string('disk', 20)->default('private');
            $table->string('path');
            $table->string('original_name');
            $table->string('mime', 100);
            $table->unsignedInteger('size');
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attachments');
    }
};
