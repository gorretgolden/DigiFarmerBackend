<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartSellerProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_seller_product', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->foreignId('cart_id')->nullable()->constrained()->onDelete('CASCADE');
            $table->foreignId('seller_product_id')->nullable()->constrained()->onDelete('CASCADE');
            $table->integer('quantity')->default(0);
            $table->string('type');
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
        Schema::dropIfExists('cart_seller_product');
    }
}

