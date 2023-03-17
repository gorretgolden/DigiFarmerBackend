<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('tx_ref');
            $table->string('flw_ref');
            $table->integer('amount');
            $table->string('currency')->nullable();
            $table->integer('charged_amount');
            $table->integer('app_fee');
            $table->integer('merchant_fee');
            $table->string('auth_model');
            $table->string('status');
            $table->string('payment_type');
            $table->string('phone_number');
            $table->string('email');
            $table->string('name');
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
        Schema::dropIfExists('transactions');
    }
}
