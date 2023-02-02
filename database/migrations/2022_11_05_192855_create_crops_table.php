<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCropsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crops', function (Blueprint $table) {
            $table->id();
            $table->string('name',100)->unique();
            $table->boolean('is_active')->default(0);
            $table->integer('standard_price');
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('CASCADE');
            $table->enum('price_unit',['per-kg','per-item'])->default('per-kg');
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
        Schema::dropIfExists('crops');
    }
}
