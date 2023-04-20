<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->foreignId('cart_id')->nullable()->constrained()->onDelete('CASCADE');
            $table->foreignId('seller_product_id')->nullable()->constrained()->onDelete('CASCADE');
            $table->foreignId('animal_feed_id')->nullable()->constrained()->onDelete('CASCADE');
            $table->foreignId('rent_vendor_service_id')->nullable()->constrained()->onDelete('CASCADE');
            $table->integer('quantity')->default(1);
            $table->integer('charge_value')->nullable();
            $table->integer('grand_total');

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
        Schema::dropIfExists('cart_items');
    }
}
