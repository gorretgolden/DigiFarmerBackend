
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
             $table->boolean('is_active')->default(0);
             $table->string('image')->nullable();
             $table->string('title');
             $table->string('type');
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
         Schema::drop('sliders');
     }
 }
