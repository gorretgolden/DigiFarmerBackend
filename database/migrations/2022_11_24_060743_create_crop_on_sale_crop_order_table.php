<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCropOnSaleCropOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crop_on_sale_crop_order', function (Blueprint $table) {
            $table->foreignId('crop_on_sale_id')->nullable()->constrained()->onDelete('CASCADE');
            $table->foreignId('crop_order_id')->nullable()->constrained()->onDelete('CASCADE');
            $table->integer('buying_price');
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
        Schema::dropIfExists('crop_on_sale_crop_order');
    }
}
