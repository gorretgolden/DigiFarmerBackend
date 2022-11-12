<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTraningVendorServicesTable extends Migration
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
            $table->string('slots');
            $table->foreignId('vendor_category_id')->constrained()->onDelete('CASCADE');;
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
        Schema::drop('training_vendor_services');
    }
}
