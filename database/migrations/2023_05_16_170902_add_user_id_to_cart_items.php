<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToCartItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cart_items', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign("user_id")->references('id')->on('users')->cascadeOnDelete()->onUpdate("CASCADE");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cart_items', function (Blueprint $table) {
            //
        });
    }
}
