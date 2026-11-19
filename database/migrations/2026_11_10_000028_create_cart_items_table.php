<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * ردیف‌های سبد
 * کالای یکسان با واحد یکسان در یک ردیف ادغام می‌شود (unique). هم مقدار واردشده (quantity_input) و هم تعداد پایه (quantity_base) ذخیره می‌شود. سقف ۱۰۰ ردیف در سرویس سبد کنترل می‌شود.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cart_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained();
            $table->string('unit', 10);                            // piece | carton
            $table->unsignedInteger('quantity_input');
            $table->unsignedInteger('quantity_base');
            $table->unique(['cart_id', 'product_id', 'unit']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
