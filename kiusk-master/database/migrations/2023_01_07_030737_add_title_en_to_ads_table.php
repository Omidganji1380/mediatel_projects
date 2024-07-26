<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTitleEnToAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ads', function (Blueprint $table) {
            $table->string('title_en')->nullable()->after('title');
            $table->string('seo_title_en')->nullable()->after('seo_title');
            $table->string('seo_description_en')->nullable()->after('seo_description');
            $table->longText('content_en')->nullable()->after('content');
            $table->longText('excerpt_en')->nullable()->after('excerpt');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ads', function (Blueprint $table) {
            $table->dropColumn(['title_en', 'seo_title_en', 'seo_description_en', 'content_en','excerpt_en']);
        });
    }
}
