<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvertisementOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advertisement_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('advertisement_type_id')->constrained('advertisement_types');
            $table->integer('days')->nullable();
            $table->string('price')->nullable();
            $table->string('currency')->nullable();
            $table->string('discount')->nullable();
            $table->string('total_price')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->nullable();
            $table->string('country_code')->nullable();
            $table->string('phone')->nullable();
            $table->string('business_name')->nullable();
            $table->string('postal_code')->nullable();
            $table->foreignId("state_id")->constrained('address_states');
            $table->foreignId("city_id")->constrained('address_cities');
            $table->text('description_fa')->nullable();
            $table->text('description_en')->nullable();
            $table->boolean('exclusive_design')->default(0);
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
        Schema::dropIfExists('advertisement_orders');
    }
}
