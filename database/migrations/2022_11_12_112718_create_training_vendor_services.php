<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainingVendorServices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('training_vendor_services', function (Blueprint $table) {
            $table->id('id');
            $table->string('name')->unique();
            $table->integer('charge');
            $table->text('description');
            $table->string('image')->nullable();
            $table->integer('period')->default(1);
            $table->string('period_unit')->default('Days');
            $table->enum('access',['Online','Offline'])->default('Online');
            $table->string('starting_date');
            $table->string('ending_date')->nullable();
            $table->time('starting_time');
            $table->time('ending_time');
            $table->text('zoom_details')->nullable();
            $table->text('location_details')->nullable();
            $table->foreignId('vendor_category_id')->constrained()->onDelete('CASCADE');
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
        Schema::dropIfExists('training_vendor_services');
    }
}
