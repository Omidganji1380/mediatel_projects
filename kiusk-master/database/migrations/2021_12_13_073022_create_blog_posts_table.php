<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
 /**
  * Run the migrations.
  * @return void
  */
 public function up()
 {
  Schema::create('blog_posts', function (Blueprint $table) {
   $table->id();
   $table->string('title');
   $table->string('slug')
         ->unique();
   $table->longText('content');
   $table->longText('excerpt')
         ->nullable();
   $table->boolean('is_visible')
         ->default(true);
   $table->date('published_at')
         ->nullable();
   $table->string('seo_title')
         ->nullable();
   $table->string('seo_description')
         ->nullable();
   $table->bigInteger('views')
         ->default(0);
   $table->json('extra')
         ->nullable();
   $table->timestamps();
  });
 }

 /**
  * Reverse the migrations.
  * @return void
  */
 public function down()
 {
  Schema::dropIfExists('blog_posts');
 }
};
