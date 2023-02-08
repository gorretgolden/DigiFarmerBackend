<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartRentVendorServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_rent_vendor_service', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cart_id')->nullable()->constrained()->onDelete('CASCADE');
            $table->foreignId('rent_vendor_service_id')->nullable()->constrained()->onDelete('CASCADE');
            $table->integer('quantity')->default(0);
            $table->integer('charge_value');
            $table->string('type')->default('rent');
            $table->integer('total_cost')->default(0);
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
        Schema::dropIfExists('cart_rent_vendor_service');
    }
}
