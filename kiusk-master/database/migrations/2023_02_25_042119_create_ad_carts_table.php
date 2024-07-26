<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ad_carts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('advertisement_type_id')->constrained('advertisement_types')->onDelete('cascade');
            $table->foreignId('advertisement_order_id')->constrained('advertisement_orders')->onDelete('cascade');
            $table->string('title')->nullable();
            $table->string('price')->nullable();
            $table->string('invoice_period')->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('ad_carts');
    }
}
