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
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('CASCADE');
            $table->string('transaction_ref');
            $table->string('order_ref');
            $table->string('external_ref');
            $table->string('narration')->nullable();
            $table->enum('status',['success-pending-validation','success-completed','success-completed-failed'])->default('success-pending-validation');
            $table->enum('payment_type',['mobilemoneyug','card'])->default('mobilemoneyug');
            $table->enum('transaction_type',['collection','payment'])->default('collection');
            $table->enum('is_live',[0,1])->default(0);
            $table->string('phone_number');
            $table->string('email');
            $table->string('amount');
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
