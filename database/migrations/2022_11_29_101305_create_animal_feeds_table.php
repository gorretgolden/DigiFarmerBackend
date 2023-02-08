<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnimalFeedsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('animal_feeds', function (Blueprint $table) {
            $table->id('id');
            $table->string('name');
            $table->integer('price');
            $table->string('image');
            $table->string('price_unit')->default('UGX');
            $table->integer('weight');
            $table->string('weight_unit')->default('UGX');
            $table->string('location');
            $table->integer('stock_anmount')->default(0);
            $table->status('status');
            $table->boolean('is_verified')->default(false);
            $table->text('description')->nullable();
            $table->foreignId('animal_feed_category_id')->nullable()->constrained()->onDelete('CASCADE');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('CASCADE');
            $table->foreignId('vendor_category_id')->nullable()->constrained()->onDelete('CASCADE');
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
        Schema::drop('animal_feeds');
    }
}
