<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTelegramAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('telegram_ads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('category_id')->nullable()->constrained('ad_categories')->nullOnDelete();
            $table->text('description')->nullable();
            $table->text('description_en')->nullable();
            $table->text('image_url')->nullable();
            $table->text('image_en_url')->nullable();
            $table->string('link')->nullable();
            $table->boolean('is_approved')->default(0);
            $table->string('ad_type');
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
        Schema::dropIfExists('telegram_ads');
    }
}
