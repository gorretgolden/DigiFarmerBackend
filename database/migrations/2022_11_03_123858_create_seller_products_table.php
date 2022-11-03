
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
             $table->string('name',100);
             $table->text('description');
             $table->string('iamge');
             $table->integer('price');
             $table->foreignId('seller_product_category_id')->nullable()->constrained()->onDelete('CASCADE');
             $table->string('image')->nullable();
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


