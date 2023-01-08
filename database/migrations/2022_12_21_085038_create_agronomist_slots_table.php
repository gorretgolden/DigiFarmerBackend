<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgronomistSlotsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agronomist_slots', function (Blueprint $table) {
            $table->id('id');
            $table->string('time');
            $table->integer('status')->default(0);
            $table->foreignId('agronomist_shedule_id')->nullable()->constrained()->onDelete('CASCADE');
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
        Schema::drop('agronomist_slots');
    }
}
