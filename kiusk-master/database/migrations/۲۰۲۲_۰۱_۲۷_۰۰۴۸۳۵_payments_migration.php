<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PaymentsMigration extends Migration
{
 public function up()
 {
  Schema::table('payments', function (Blueprint $table) {
   $table->after('id', function (Blueprint $table) {
    $table->foreignId('user_id')
          ->nullable()
          ->constrained()
          ->cascadeOnDelete();
   });
  });
 }

 public function down()
 {
  Schema::table('payments', function (Blueprint $table) {
   $table->dropForeign(['user_id']);
  });
 }
}