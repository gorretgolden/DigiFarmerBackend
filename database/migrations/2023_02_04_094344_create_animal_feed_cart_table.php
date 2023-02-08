<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnimalFeedCartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('animal_feed_cart', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cart_id')->nullable()->constrained()->onDelete('CASCADE');
            $table->foreignId('animal_feed_id')->nullable()->constrained()->onDelete('CASCADE');
            $table->integer('quantity')->default(0);
            $table->string('type');
            $table->integer('total_cost')->default(0);
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
        Schema::dropIfExists('animal_feed_cart');
    }
}
