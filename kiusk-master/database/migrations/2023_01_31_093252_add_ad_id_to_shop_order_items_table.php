<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdIdToShopOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shop_order_items', function (Blueprint $table) {
            $table->foreignId('ad_id')->constrained('ads')->after('plan_id');
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
            $table->dropForeign('ad_id');
            $table->dropColumn('ad_id');
        });
    }
}
