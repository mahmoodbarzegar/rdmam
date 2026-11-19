<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * شهرها
 * هر شهر به یک استان تعلق دارد و هر استان چند شهر دارد. نام شهر فقط در محدوده همان استان یکتا است (دو استان می‌توانند شهری با نام یکسان داشته باشند). حذف استان‌ی که شهر دارد مجاز نیست.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('province_id')->constrained()->restrictOnDelete();
            $table->string('name', 80);
            $table->string('erp_code', 30)->nullable()->unique();
            $table->boolean('is_active')->default(true);
            $table->unique(['province_id', 'name']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cities');
    }
};
