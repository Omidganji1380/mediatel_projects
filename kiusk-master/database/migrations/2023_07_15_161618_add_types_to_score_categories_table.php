<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypesToScoreCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('score_categories', function (Blueprint $table) {
            $table->string('type')->nullable()->after('is_active');
            $table->text('extra')->nullable()->after('type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('score_categories', function (Blueprint $table) {
            $table->dropColumn(['type', 'extra']);
        });
    }
}
