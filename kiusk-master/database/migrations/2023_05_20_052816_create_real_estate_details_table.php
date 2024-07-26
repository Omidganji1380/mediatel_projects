<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRealEstateDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('real_estate_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ad_id')->constrained('ads');
            $table->string('rooms')->nullable();
            $table->string('sale_price')->nullable();
            $table->string('rent_price')->nullable();
            $table->string('mortgage_price')->nullable();
            $table->string('user_type')->nullable(); // Person or Real Estate
            $table->integer('floor')->nullable();
            $table->boolean('elevator')->nullable();
            $table->boolean('warehouse')->nullable();
            $table->boolean('balcony')->nullable();
            $table->string('area')->nullable();
            $table->string('area_unit')->nullable();
            $table->string('bathroom')->nullable();
            $table->string('yearly_tax')->nullable();
            $table->string('price_keep')->nullable();
            $table->string('construction_year')->nullable();
            $table->string('mls_number')->nullable();
            $table->timestamp('availability_date')->nullable();
            $table->boolean('show_tel')->default(1);
            $table->boolean('show_email')->default(1);
            $table->text('facilities')->nullable();
            $table->text('nearby_facilities')->nullable();
            $table->text('building_facilities')->nullable();
            $table->text('unit_facilities')->nullable();
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->string('post_type')->nullable();
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
        Schema::dropIfExists('real_estate_details');
    }
}
