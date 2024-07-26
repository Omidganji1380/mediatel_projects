<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToGoogleReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('google_reviews', function (Blueprint $table) {
            $table->string('google_ref')->unique(); // Google Review ID reference
            $table->unsignedTinyInteger('rating');
            $table->text('comment')->nullable();
            $table->string('title')->nullable();
            $table->string('name')->nullable();
            $table->string('photo')->nullable();
            $table->text('extra')->nullable();
            $table->dateTime('reviewed_at')->nullable();
            $table->dateTime('review_updated_at')->nullable();
            $table->text('reply')->nullable();
            $table->boolean('is_displayable')->default(false); // Mark true if review should be displayed on website
            $table->boolean('is_photo_displayable')->default(false); // Mark true if website should display the reviewer_photo as well or just use the reviewer image placeholder
            $table->unsignedBigInteger('google_link_id')->nullable();
            $table->foreign('google_link_id')->references('id')->on('google_links')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('google_reviews', function (Blueprint $table) {
            $table->dropForeign('google_link_id');
            $table->dropColumn([
                'google_ref',
                'rating',
                'comment',
                'title',
                'name',
                'photo',
                'extra',
                'reviewed_at',
                'review_updated_at',
                'reply',
                'is_displayable',
                'is_photo_displayable',
                'google_link_id'
            ]);
        });
    }
}
