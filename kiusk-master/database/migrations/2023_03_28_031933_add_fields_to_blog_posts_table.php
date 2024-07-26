<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToBlogPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->string('current_url')->nullable()->after('slug');
            $table->string('old_url')->nullable()->after('current_url');
            $table->string('rel_canonical')->nullable()->after('old_url');
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
                'current_url' ,
                'old_url',
                'rel_canonical'
            ]);
        });
    }
}
