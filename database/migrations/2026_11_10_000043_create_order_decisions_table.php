<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * تصمیم‌های مدیر شعبه
 * سه نتیجه ممکن: تأیید، بازگشت برای اصلاح (با توضیح) و رد (با دلیل اجباری). مدیر شعبه مقدار یا قیمت را تغییر نمی‌دهد و تأیید گروهی وجود ندارد.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_decisions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('order_revision_id')->constrained()->cascadeOnDelete();
            $table->foreignId('decided_by')->constrained('users');
            $table->string('decision', 10);
            $table->text('reason')->nullable();
            $table->timestamp('decided_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_decisions');
    }
};
