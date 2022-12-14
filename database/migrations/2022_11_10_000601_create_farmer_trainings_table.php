<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFarmerTrainingsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('farmer_trainings', function (Blueprint $table) {
            $table->id('id');
            $table->string('starting_date');
            $table->string('ending_date');
            $table->enum('access',['online','offline']);
            $table->integer('period');
            $table->string('period_unit');
            $table->string('farmer_time');
            $table->enum('status',['Open','Inprogress'])->default('Open');
            $table->foreignId('training_vendor_service_id')->constrained()->onDelete('CASCADE');;
            $table->foreignId('user_id')->constrained()->onDelete('CASCADE');
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
        Schema::drop('farmer_trainings');
    }
}
