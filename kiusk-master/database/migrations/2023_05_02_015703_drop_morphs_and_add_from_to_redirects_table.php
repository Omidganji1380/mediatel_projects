<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropMorphsAndAddFromToRedirectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('redirects', function (Blueprint $table) {
            $table->dropMorphs('redirectable');
            $table->string('from')->nullable()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('redirects', function (Blueprint $table) {
            $table->dropColumn('from');
            $table->morphs('redirectable');
        });
    }
}
