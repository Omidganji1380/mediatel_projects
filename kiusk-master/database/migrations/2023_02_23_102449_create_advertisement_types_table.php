<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvertisementTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advertisement_types', function (Blueprint $table) {
            $table->id();
            $table->string('name_fa')->nullable();
            $table->string('name_en')->nullable();
            $table->string('slug')->nullable();
            $table->text('description_fa')->nullable();
            $table->text('description_en')->nullable();
            $table->integer('days')->nullable();
            $table->string('price')->nullable();
            $table->string('position')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('advertisement_types');
    }
}
