<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFavoritesTable extends Migration
{
 public function up()
 {
  Schema::create('ad_favorites', function (Blueprint $table) {
   $table->id();
   $table->foreignId('user_id')->constrained('users');
   $table->foreignId('ad_id')->constrained('ads');
   $table->timestamps();
  });
 }

 public function down()
 {
  Schema::dropIfExists('ad_favorites');
 }
}
