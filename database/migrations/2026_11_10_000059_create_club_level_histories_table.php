<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * تاریخچه تغییر سطح
 * سوابق ارتقا، تنزل و تغییر دستی سطح همراه با مبلغ خرید ۹۰ روزه در لحظه تغییر.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('club_level_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->foreignId('from_level_id')->nullable()->constrained('club_levels')->nullOnDelete();
            $table->foreignId('to_level_id')->nullable()->constrained('club_levels')->nullOnDelete();
            $table->string('reason', 20);                        // upgrade | downgrade | manual
            $table->bigInteger('rolling_net_sales')->default(0);
            $table->foreignId('changed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('changed_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('club_level_histories');
    }
};
