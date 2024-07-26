<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOldSlugToAdCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ad_categories', function (Blueprint $table) {
            $table->string('old_slug')->nullable()->after('slug');
            $table->string('current_url')->nullable()->after('old_slug');
            $table->string('old_url')->nullable()->after('current_url');
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
            $table->dropColumn([
                'old_slug',
                'current_url' ,
                'old_url',
            ]);
        });
    }
}
