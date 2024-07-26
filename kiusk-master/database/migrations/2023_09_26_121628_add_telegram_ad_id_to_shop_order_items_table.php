<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTelegramAdIdToShopOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shop_order_items', function (Blueprint $table) {
            $table->unsignedBigInteger('telegram_ad_id')->nullable()->after('ad_id');
            $table->foreign('telegram_ad_id')->references('id')->on('telegram_ads');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shop_order_items', function (Blueprint $table) {
            $table->dropForeign('telegram_ad_id');
            $table->dropColumn('telegram_ad_id');
        });
    }
}
