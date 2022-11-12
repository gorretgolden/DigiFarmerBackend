<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCropOnSalesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crop_on_sales', function (Blueprint $table) {
            $table->id('id');
            $table->integer('quantity');
            $table->integer('selling_price');
            $table->string('price_unit');
            $table->text('description');
            $table->string('image');
            $table->string('status');
            $table->foreignId('crop_id')->nullable()->constrained()->onDelete('CASCADE');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('CASCADE');
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
        Schema::drop('crop_on_sales');
    }
}
