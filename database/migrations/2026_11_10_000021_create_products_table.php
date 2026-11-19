<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * کالاها
 * دو دسته ستون دارد: ستون‌های ERP که رادمان تغییرشان نمی‌دهد (کد، کد فنی، عنوان، واحد، ضریب فروش، قیمت پایه، ویژگی‌ها) و ستون‌های تکمیلی مدیر مرکزی (تصویر، توضیح، ترتیب، تعداد در کارتن). ستون‌های *_normalized بعد از یکدست‌سازی «ی/ک»، ارقام و فاصله پر می‌شوند و مقدار اصلی دست‌نخورده می‌ماند. کالا فقط وقتی is_orderable=true است که شناسه، عنوان، واحد، ضریب فروش و قیمت معتبر داشته باشد. فروش کارتنی فقط وقتی carton_qty ثبت شده باشد ممکن است.
 */
return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('erp_code')->unique();
            $table->string('erp_id')->unique();
            $table->string('name');
            $table->enum(
                'default_unit',
                array_column(\App\Enums\ProductDefaultUnit::cases(), 'value')
            )->default(\App\Enums\ProductDefaultUnit::Piece->value);

            $table->enum(
                'main_unit',
                array_column(\App\Enums\ProductDefaultUnit::cases(), 'value')
            )->default(\App\Enums\ProductDefaultUnit::Piece->value);

            $table->foreignId('brand_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->json('erp_attributes')->nullable();
            $table->string('type')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->string('min_order_qty')->default(1);
            $table->string('max_order_qty')->default(1);
            $table->string('min_order_carton_qty')->nullable();
            $table->string('max_order_carton_qty')->nullable();
            $table->string('settlement_deadline_days')->default(3);
            $table->timestamp('erp_synced_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
