<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogReviewsTable extends Migration
{
 public function up()
 {
  Schema::create('blog_comments', function (Blueprint $table) {
   $table->id();
   $table->text('title')
         ->nullable();
   $table->text('content')
         ->nullable();
   $table->boolean('is_visible')
         ->default(false);
   $table->timestamps();
  });
 }

 public function down()
 {
  Schema::dropIfExists('blog_comments');
 }
}