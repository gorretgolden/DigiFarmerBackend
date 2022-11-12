<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainingVendorServiceSlots extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('training_vendor_service_slots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('training_vendor_service_id')->constrained()->onDelete('CASCADE');
            $table->string('starting_time');
            $table->string('ending_time');
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
        Schema::dropIfExists('training_vendor_service_slots');
    }
}
