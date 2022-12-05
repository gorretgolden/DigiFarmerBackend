
<?php

 use Illuminate\Database\Migrations\Migration;
 use Illuminate\Database\Schema\Blueprint;
 use Illuminate\Support\Facades\Schema;

 class CreateRentVendorImagesTable extends Migration
 {

     /**
      * Run the migrations.
      *
      * @return void
      */
     public function up()
     {
         Schema::create('rent_vendor_images', function (Blueprint $table) {
             $table->id('id');
             $table->string('url');
             $table->foreignId('rent_vendor_service_id')->nullable()->constrained()->onDelete('CASCADE');
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
         Schema::drop('rent_vendor_images');
     }
 }
