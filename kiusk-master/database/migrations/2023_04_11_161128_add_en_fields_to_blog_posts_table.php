<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEnFieldsToBlogPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->string('title_en')->nullable()->after('title');
            $table->longText('content_en')->nullable()->after('content');
            $table->text('excerpt_en')->nullable()->after('excerpt');
            $table->text('seo_title_en')->nullable()->after('seo_title');
            $table->text('seo_description_en')->nullable()->after('seo_description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->dropColumn([
                'title_en',
                'content_en',
                'excerpt_en',
                'seo_title_en',
                'seo_description_en',
            ]);
        });
    }
}
