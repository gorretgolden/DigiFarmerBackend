
<?php

 use Illuminate\Database\Migrations\Migration;
 use Illuminate\Database\Schema\Blueprint;
 use Illuminate\Support\Facades\Schema;

 class CreateFarmsTable extends Migration
 {

     /**
      * Run the migrations.
      *
      * @return void
      */
     public function up()
     {
         Schema::create('farms', function (Blueprint $table) {
             $table->id('id');
             $table->string('name')->unique();
             $table->string('owner');
             $table->integer('field_area');
             $table->enum('size_unit',['Hectares','Acres'])->default('Acres');
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
         Schema::drop('farms');
     }
 }

