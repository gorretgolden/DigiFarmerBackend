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
            $table->integer('charge');
            $table->integer('charge_day')->default(1);
            $table->string('charge_unit')->default('UGX');
            $table->string('charge_frequency')->default('day');
            $table->integer('total_charge')->default(0);
            $table->text('description');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('CASCADE');
            $table->foreignId('rent_vendor_sub_category_id')->nullable()->constrained()->onDelete('CASCADE');
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
