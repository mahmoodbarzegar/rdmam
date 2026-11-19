<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * کلیدهای خارجی حلقوی: orders <-> order_revisions و campaigns <-> campaign_versions.
 * این‌ها بعد از ساخت هر دو جدول اضافه می‌شوند تا ترتیب مایگریشن‌ها مشکل نداشته باشد.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->foreign('current_revision_id')->references('id')->on('order_revisions')->nullOnDelete();
            $table->foreign('approved_revision_id')->references('id')->on('order_revisions')->nullOnDelete();
        });

        Schema::table('campaigns', function (Blueprint $table) {
            $table->foreign('current_version_id')->references('id')->on('campaign_versions')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['current_revision_id']);
            $table->dropForeign(['approved_revision_id']);
        });

        Schema::table('campaigns', function (Blueprint $table) {
            $table->dropForeign(['current_version_id']);
        });
    }
};
