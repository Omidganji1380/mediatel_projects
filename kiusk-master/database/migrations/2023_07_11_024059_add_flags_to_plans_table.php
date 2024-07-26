<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFlagsToPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->boolean('motion_story')->default(0)->after('pin_ad');
            $table->boolean('story')->default(0)->after('pin_ad');
            $table->boolean('free_blog_ad')->default(0)->after('pin_ad');
            $table->boolean('telegram_group_ad')->default(0)->after('pin_ad');
            $table->boolean('telegram_channel')->default(0)->after('pin_ad');
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
            $table->dropColumn(['motion_story', 'story', 'free_blog_ad', 'telegram_group_ad', 'telegram_channel']);
        });
    }
}
