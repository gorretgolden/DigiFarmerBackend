<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVeterinariesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('veterinaries', function (Blueprint $table) {
            $table->id('id');
            $table->string('name')->unique();
            $table->text('expertise',255);
            $table->integer('charge');
            $table->string('charge_unit')->default('Per Hour');
            $table->enum('availability',['Chat','Online','Call','In-Person'])->default('In-Person');
            $table->text('description');
            $table->text('zoom_details')->nullable();
            $table->string('location')->nullable();
            $table->string('image')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('CASCADE');
            $table->foreignId('vendor_category_id')->nullable()->constrained()->onDelete('CASCADE');
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
        Schema::drop('veterinaries');
    }
}
