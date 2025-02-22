<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitiesTable extends Migration
{
 public function up()
 {
  Schema::create('address_cities', function (Blueprint $table) {
   $table->id();
   $table->string('name', 255)
         ->nullable();
   $table->string('slug', 255)
         ->nullable();
   $table->string('seo_title')
         ->nullable();
   $table->string('seo_description')
         ->nullable();
   $table->timestamps();
  });
 }

 public function down()
 {
  Schema::dropIfExists('address_cities');
 }
}
