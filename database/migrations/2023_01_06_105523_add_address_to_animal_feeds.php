<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAddressToAnimalFeeds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('animal_feeds', function (Blueprint $table) {
            $table->unsignedInteger('address_id')->nullable()->references('id')->on('addresses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('animal_feeds', function (Blueprint $table) {
            $table->dropColumn('address_id');
        });
    }
}
