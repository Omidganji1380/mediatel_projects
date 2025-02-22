<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTaxToAdCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ad_carts', function (Blueprint $table) {
            $table->integer('tax')->nullable()->after('price');
            $table->float('total_price', 8, 2)->nullable()->after('price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ad_carts', function (Blueprint $table) {
            $table->dropColumn(['tax', 'total_price']);
        });
    }
}
