<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCropBuyersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crop_buyers', function (Blueprint $table) {
            $table->id('id');
            $table->integer('buying_price');
            $table->boolean('has_bought')->default(false);
            $table->string('contact_one');
            $table->string('contact_two')->nullable();
            $table->string('email');
            $table->text('description');
            $table->boolean('is_accepted')->default(false);
            $table->foreignId('crop_on_sale_id')->constrained();
            $table->foreignId('user_id')->constrained()->onDelete('CASCADE');
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
        Schema::drop('crop_buyers');
    }
}
