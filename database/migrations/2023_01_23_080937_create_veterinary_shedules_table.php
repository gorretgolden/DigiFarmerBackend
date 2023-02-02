<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVeterinaryShedulesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('veterinary_shedules', function (Blueprint $table) {
            $table->id('id');
            $table->string('date');
            $table->string('starting_time');
            $table->string('ending_time');
            $table->integer('time_interval');
            $table->foreignId('veterinary_id')->nullable()->constrained()->onDelete('CASCADE');
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
        Schema::drop('veterinary_shedules');
    }
}
