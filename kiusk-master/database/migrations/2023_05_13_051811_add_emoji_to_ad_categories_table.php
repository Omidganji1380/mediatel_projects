<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmojiToAdCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ad_categories', function (Blueprint $table) {
            $table->string('emoji')->nullable()->after('name_en');
            $table->boolean('show_in_telegram')->default(0)->after('emoji');
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
            $table->dropColumn(['show_in_telegram', 'emoji']);
        });
    }
}
