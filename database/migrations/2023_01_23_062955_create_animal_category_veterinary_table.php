<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnimalCategoryVeterinaryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('animal_category_veterinary', function (Blueprint $table) {
            $table->id();
            $table->foreignId('animal_category_id')->nullable()->constrained()->onDelete('CASCADE');
            $table->foreignId('veterinary_id')->nullable()->constrained()->onDelete('CASCADE');
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
        Schema::dropIfExists('animal_category_veterinary');
    }
}
