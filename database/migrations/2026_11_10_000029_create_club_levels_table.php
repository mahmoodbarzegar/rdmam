<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * سطح‌های باشگاه
 * تعداد، نام و ترتیب سطح‌ها (برنزی، نقره‌ای، طلایی و غیره) و آستانه خرید هر سطح بر اساس خرید خالص دوره محاسبه. مزایای هر سطح در benefits ذخیره می‌شود، ولی مزیت مالی فقط از مسیر «کمپین ویژه سطح» اعمال می‌شود.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('club_levels', function (Blueprint $table) {
            $table->id();
            $table->string('name', 60);
            $table->unsignedTinyInteger('level_order')->unique();
            $table->unsignedBigInteger('min_amount')->default(0);      // حداقل خرید خالص دوره (ریال)
            $table->unsignedBigInteger('max_amount')->nullable();
            $table->json('benefits')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('club_levels');
    }
};
