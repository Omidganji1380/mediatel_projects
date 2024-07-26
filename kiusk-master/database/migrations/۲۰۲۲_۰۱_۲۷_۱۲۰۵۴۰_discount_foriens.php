<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DiscountForiens extends Migration
{
 public function up()
 {
  Schema::table('payment_discounts', function (Blueprint $table) {
   $table->after('id', function (Blueprint $table) {
    $table->foreignId('payment_id')
          ->nullable()
          ->constrained()
          ->cascadeOnDelete();
   });
  });
 }

 public function down()
 {
  Schema::table('payment_discounts', function (Blueprint $table) {
   $table->dropForeign(['payment_id']);
  });
 }
}