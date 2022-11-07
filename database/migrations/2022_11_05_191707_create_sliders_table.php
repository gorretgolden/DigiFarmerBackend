
<?php

 use Illuminate\Database\Migrations\Migration;
 use Illuminate\Database\Schema\Blueprint;
 use Illuminate\Support\Facades\Schema;

 class CreateSlidersTable extends Migration
 {

     /**
      * Run the migrations.
      *
      * @return void

      */
     public function up()
     {
         Schema::create('sliders', function (Blueprint $table) {
             $table->id('id');
             $table->string('image')->nullable();
             $table->string('title');
             $table->timestamps();
             $table->softDeletes();
         });
     }

     /**
      * Reverse the migrations.
      *
      * @return void
      */
     public function down()
     {
         Schema::drop('sliders');
     }
 }