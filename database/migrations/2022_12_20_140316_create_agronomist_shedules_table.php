<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgronomistShedulesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agronomist_shedules', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('day_id')->nullable()->constrained()->onDelete('CASCADE');
            $table->foreignId('agronomist_vendor_service_id')->nullable()->constrained()->onDelete('CASCADE');
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
        Schema::drop('agronomist_shedules');
    }
}
