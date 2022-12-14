<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellerProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seller_products', function (Blueprint $table) {
            $table->id();
             $table->string('name',100)->unique();
             $table->string('image')->nullable();
             $table->integer('price');
             $table->text('description');
             $table->foreignId('seller_product_category_id')->nullable()->constrained()->onDelete('CASCADE');
             $table->foreignId('user_id')->constrained()->onDelete('CASCADE');
             $table->enum('status',['on-sale','sold'])->default('on-sale');
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
        Schema::dropIfExists('seller_products');
    }
}


