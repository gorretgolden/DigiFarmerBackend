<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{

    //id,  total_amount, amount_paid, baker_id, transaction_ref, created_at, updated_at, delivery_fee, external_ref, instructions, order_code
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('payment_method')->default('mobile_money');
            $table->unsignedBigInteger('user_id');
            $table->foreign("user_id")->references('id')->on('users')->cascadeOnDelete()->onUpdate("CASCADE");
            $table->enum('order_status', ['pending', 'completed', 'cancelled'])->default('pending');
            $table->enum('payment_status', ['paid', 'unpaid'])->default('unpaid');
            $table->integer('total_amount')->default(0);
            $table->integer('amount_paid')->default(0);
            $table->string('transaction_ref')->nullable();
            $table->string('external_ref')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
