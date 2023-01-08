<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCropsOnSaleTable extends Migration
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
            $table->integer('quantity')->nullable();
            $table->integer('selling_price');
            $table->text('description');
            $table->string('image')->nullable();
            $table->string('quantity_unit')->default('kg');
            $table->string('price_unit')->default('UGX');
            $table->boolean('is_sold')->default(false);
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
        Schema::dropIfExists('crop_on_sales');
    }
}
