<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddViewToTelegramAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('telegram_ads', function (Blueprint $table) {
            $table->bigInteger('views')->default(0)->after('is_approved');
            $table->boolean('is_paid')->default(0)->after('is_approved');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('telegram_ads', function (Blueprint $table) {
            $table->dropColumn(['views', 'is_paid']);
        });
    }
}
