<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * پارامترهای باشگاه (تک‌ردیف)
 * ردیف واحد تنظیمات: دوره محاسبه سطح (۹۰ روز متحرک)، مبلغ به ازای هر امتیاز (همان X)، ارزش ریالی امتیاز، مدت اعتبار (۳۶۵ روز)، زمان تخصیص و پارامترهای مصرف. redemption_enabled در فاز اول false است، چون امتیاز پول یا ابزار پرداخت نیست.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('club_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('level_period_days')->default(90);
            $table->unsignedBigInteger('amount_per_point')->nullable();          // به ازای هر چند ریال فروش خالص یک امتیاز (X)
            $table->decimal('points_per_step', 10, 2)->default(1);
            $table->unsignedBigInteger('rial_value_per_point')->nullable();
            $table->unsignedSmallInteger('points_expiry_days')->default(365);
            $table->string('award_timing', 30)->default('on_final_invoice');
            $table->boolean('redemption_enabled')->default(false);
            $table->decimal('min_redeem_points', 12, 2)->nullable();
            $table->decimal('max_redeem_points_per_order', 12, 2)->nullable();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('club_settings');
    }
};
