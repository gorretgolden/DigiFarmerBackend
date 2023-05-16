<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartPivotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_pivots', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign("user_id")->references('id')->on('users')->cascadeOnDelete()->onUpdate("CASCADE");
            $table->foreignId('cart_id')->nullable()->constrained()->onDelete('CASCADE');
            $table->unsignedBigInteger('vendor_service_id');
            $table->foreign("vendor_service_id")->references('id')->on('vendor_services')->cascadeOnDelete()->onUpdate("CASCADE");
            $table->integer('quantity')->default(1);
            $table->string('type');
            $table->integer('charge_value')->nullable();
            $table->integer('total_cost')->nullable();
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
        Schema::dropIfExists('cart_pivots');
    }
}
