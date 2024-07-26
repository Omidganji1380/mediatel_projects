<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_messages', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->integer('user_count')->default(0);
            $table->text('message')->nullable();
            $table->boolean('all')->default(0);
            $table->boolean('business_owner')->default(0);
            $table->boolean('seller')->default(0);
            $table->boolean('real_estate')->default(0);
            $table->boolean('property_applicant')->default(0);
            $table->longText('extra')->nullable();
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
        Schema::dropIfExists('user_messages');
    }
}
