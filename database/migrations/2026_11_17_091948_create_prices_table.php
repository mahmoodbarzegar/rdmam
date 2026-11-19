<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->nullable()->constrained()->cascadeOnDelete();
            $table->enum(
                'unit',
                array_column(\App\Enums\ProductDefaultUnit::cases(), 'value')
            )->default(\App\Enums\ProductDefaultUnit::Piece->value);
            $table->unsignedBigInteger('price');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->boolean('is_approved')->default(false);
            $table->string('erp_title')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prices');
    }
};
