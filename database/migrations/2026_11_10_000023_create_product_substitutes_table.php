<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * قطعات جایگزین
 * فقط با رابطه فنی تأییدشده تعریف می‌شود و جایگزینی خودکار در سبد وجود ندارد؛ این جدول فقط برای نمایش پیشنهاد است.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_substitutes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('substitute_id')->constrained('products')->cascadeOnDelete();
            $table->string('relation_type', 30)->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->unique(['product_id', 'substitute_id']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_substitutes');
    }
};
