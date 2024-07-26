<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRgtLftToAdCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ad_categories', function (Blueprint $table) {
            $table->bigInteger('_rgt')->nullable()->after('parent_id');
            $table->bigInteger('_lft')->nullable()->after('parent_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ad_categories', function (Blueprint $table) {
            $table->dropColumn(['_lft', '_rgt']);
        });
    }
}
