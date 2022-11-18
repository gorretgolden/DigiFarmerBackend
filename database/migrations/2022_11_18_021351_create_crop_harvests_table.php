<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCropHarvestsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crop_harvests', function (Blueprint $table) {
            $table->id('id');
            $table->integer('quantity');
            $table->string('quantity_unit');
            $table->foreignId('plot_id')->nullable()->constrained()->onDelete('CASCADE');
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
        Schema::drop('crop_harvests');
    }
}
