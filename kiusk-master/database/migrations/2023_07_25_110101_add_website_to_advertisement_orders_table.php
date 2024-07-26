<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWebsiteToAdvertisementOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('advertisement_orders', function (Blueprint $table) {
            $table->string('website')->nullable()->after('phone_2');
            $table->string('url')->nullable()->after('website');
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
            $table->dropColumn(['website', 'url']);
        });
    }
}
