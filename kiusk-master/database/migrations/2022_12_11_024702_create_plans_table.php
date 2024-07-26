<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name_fa')->nullable();
            $table->string('name_en')->nullable();
            $table->string('slug')->nullable();
            $table->string('price')->nullable();
            $table->string('currency')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(1);
            $table->boolean('email_notification')->default(0);
            $table->boolean('sms_notification')->default(0);
            $table->integer('invoice_period')->default(0);
            $table->string('invoice_interval')->nullable();
            $table->string('type')->nullable();
            $table->integer('limit')->default(0);
            $table->integer('featured_limit')->default(0);
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
        Schema::dropIfExists('plans');
    }
}
