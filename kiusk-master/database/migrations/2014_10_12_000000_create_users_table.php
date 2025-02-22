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
  Schema::create('users', function (Blueprint $table) {
   $table->id();
   $table->string('name')
         ->nullable();
   $table->string('first_name')
         ->nullable();
   $table->string('last_name')
         ->nullable();
   $table->string('country_code')
         ->nullable();
   $table->string('phone')
         ->nullable();
   $table->date('birthday')
         ->nullable();
   $table->string('address')
         ->nullable();
   $table->string('description')
         ->nullable();
   $table->string('rule')
         ->nullable();
   $table->string('email')
         ->unique();
   $table->timestamp('email_verified_at')
         ->nullable();
   $table->string('password')
         ->nullable();
   $table->rememberToken();
   $table->bigInteger('telegram_id')
         ->nullable();
   $table->string('telegram_first_name')
         ->nullable();
   $table->string('telegram_last_name')
         ->nullable();
   $table->string('telegram_username')
         ->nullable();
   $table->string('telegram_last_message')
         ->nullable();
   $table->string('telegram_last_method')
         ->nullable();
   $table->bigInteger('telegram_last_message_id')
         ->nullable();
   $table->json('extra')
         ->nullable();
   $table->timestamp("last_online_at")
         ->useCurrent();
   $table->timestamps();
  });
 }

 /**
  * Reverse the migrations.
  * @return void
  */
 public function down()
 {
  Schema::dropIfExists('users');
 }
};
