<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAnimalCategoryIdToAnimalFeedCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('animal_feed_categories', function (Blueprint $table) {
            $table->unsignedInteger('animal_category_id')->nullable()->references('id')->on('animal_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('animal_feed_categories', function (Blueprint $table) {
            $table->dropColumn('animal_category_id');
        });
    }
}
