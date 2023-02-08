<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentVendorServicesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rent_vendor_services', function (Blueprint $table) {
            $table->id('id');
            $table->string('name');
            $table->string('location');
            $table->integer('quantity');
            $table->integer('charge');
            $table->string('charge_unit')->default('UGX');
            $table->string('charge_frequency')->default('per day');
            $table->text('description');
            $table->string('image')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('CASCADE');
            $table->foreignId('vendor_category_id')->constrained()->onDelete('CASCADE');
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
        Schema::drop('rent_vendor_services');
    }
}
