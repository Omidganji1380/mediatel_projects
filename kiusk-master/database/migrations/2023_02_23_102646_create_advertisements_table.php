<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvertisementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advertisements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('advertisement_type_id')->constrained('advertisement_types');
            $table->foreignId('advertisement_order_id')->constrained('advertisement_orders');
            $table->integer('days')->nullable();
            $table->string('position')->nullable();
            $table->text('description_fa')->nullable();
            $table->text('description_en')->nullable();
            $table->boolean('exclusive_design')->default(0);
            $table->boolean('active')->default(1);
            $table->string('link')->nullable();
            $table->longText('extra')->nullable();
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
        Schema::dropIfExists('advertisements');
    }
}
