<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToAdvertisementOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('advertisement_orders', function (Blueprint $table) {
            $table->string('title')->nullable()->after('city_id');
            $table->string('title_en')->nullable()->after('title');
            $table->string('phone_2')->nullable()->after('phone');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('advertisement_orders', function (Blueprint $table) {
            $table->dropColumn(['title' ,'title_en', 'phone_2']);
        });
    }
}
