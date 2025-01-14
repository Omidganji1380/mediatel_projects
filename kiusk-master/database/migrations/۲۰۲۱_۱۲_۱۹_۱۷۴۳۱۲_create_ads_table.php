<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdsTable extends Migration
{
 public function up()
 {
  Schema::create('ads', function (Blueprint $table) {
   $table->id();
   $table->string('title', 255)
         ->nullable();
   $table->string('slug')
         ->unique()
         ->nullable();
   $table->longText('content')
         ->nullable();
   $table->longText('excerpt')
         ->nullable();
   $table->boolean('is_visible')
         ->default(false);
   $table->decimal('price', 12, 3)
         ->nullable();
   $table->boolean('is_visible_email')
         ->default(true);
   $table->string('phone')
         ->nullable();
   $table->string('email')
         ->nullable();
   $table->string('seo_title')
         ->nullable();
   $table->string('seo_description')
         ->nullable();
   $table->bigInteger('views')
         ->default(0);
   $table->bigInteger('order_column')
         ->nullable();
   $table->json('extra')
         ->nullable();
   $table->timestamps();
  });
 }

 public function down()
 {
  Schema::dropIfExists('ads');
 }
}
