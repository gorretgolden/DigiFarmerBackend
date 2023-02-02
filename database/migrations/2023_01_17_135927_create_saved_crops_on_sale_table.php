<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSavedCropsOnSaleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saved_crop_on_sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('crop_on_sale_id')->nullable()->constrained('crop_on_sales')->onDelete('CASCADE');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('CASCADE');
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
        Schema::dropIfExists('saved_crops_on_sale');
    }
}
