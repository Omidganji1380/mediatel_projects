<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShowFieldsToPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->longText('description_en')->nullable()->after('description');
            $table->boolean('show_in_sidebar')->default(0)->after('featured_limit');
            $table->boolean('show_in_suggestion')->default(0)->after('show_in_sidebar');
            $table->boolean('show_in_main_page')->default(0)->after('show_in_suggestion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->dropColumn(['show_in_sidebar', 'show_in_suggestion', 'show_in_main_page', 'description_en']);
        });
    }
}
