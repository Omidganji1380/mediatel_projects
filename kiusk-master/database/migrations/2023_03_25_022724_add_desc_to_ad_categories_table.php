<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDescToAdCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ad_categories', function (Blueprint $table) {
            $table->longText('full_description')->nullable()->after('description_en');
            $table->longText('full_description_en')->nullable()->after('full_description');
            $table->longText('tag_line')->nullable()->after('full_description_en');
            $table->longText('tag_line_en')->nullable()->after('tag_line');
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
            $table->dropColumn(['full_description', 'full_description_en', 'tag_line', 'tag_line_en']);
        });
    }
}
