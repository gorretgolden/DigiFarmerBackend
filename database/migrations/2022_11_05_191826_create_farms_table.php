
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
             $table->string('name');
             $table->string('latitude');
             $table->string('longitude');
             $table->double('field_area')->nullable();
             $table->string('image')->nullable();
             $table->foreignId('user_id')->nullable()->constrained()->onDelete('CASCADE');
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
         Schema::drop('farms');
     }
 }

