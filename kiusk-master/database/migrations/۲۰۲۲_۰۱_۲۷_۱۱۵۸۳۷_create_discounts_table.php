<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountsTable extends Migration
{
 public function up()
 {
  Schema::create('payment_discounts', function (Blueprint $table) {
   $table->id();
   $table->string('code')
         ->unique();
   $table->decimal('percent')
         ->nullable();
   $table->decimal('amount')
         ->nullable();
   $table->timestamps();
  });
 }

 public function down()
 {
  Schema::dropIfExists('payment_discounts');
 }
}