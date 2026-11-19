<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * عضویت و موجودی امتیاز
 * همه مشتریان تأییدشده به‌صورت خودکار عضو می‌شوند. points_balance برای نمایش سریع است و منبع حقیقت، دفتر club_point_transactions است. rolling_net_sales نتیجه فرمول S_t (جمع خرید خالص ۹۰ روز اخیر) است.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('club_memberships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->unique()->constrained()->cascadeOnDelete();
            $table->foreignId('club_level_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('points_balance', 14, 2)->default(0);
            $table->bigInteger('rolling_net_sales')->default(0);
            $table->timestamp('level_calculated_at')->nullable();
            $table->timestamp('joined_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('club_memberships');
    }
};
