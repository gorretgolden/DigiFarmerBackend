<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinanceVendorServicesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finance_vendor_services', function (Blueprint $table) {
            $table->id('id');
            $table->string('name');
            $table->string('loan_number')->unique();
            $table->integer('principal');
            $table->integer('interest_rate');
            $table->string('interest_rate_unit')->default('%');
            $table->integer('payment_frequency_pay')->default(0);
            $table->enum('status',['secured','unsecured'])->default('secured');
            $table->integer('simple_interest')->default(0);
            $table->integer('total_amount_paid_back')->default(0);
            $table->foreignId('vendor_category_id')->constrained()->onDelete('CASCADE');
            $table->foreignId('finance_vendor_category_id')->constrained()->onDelete('CASCADE');
            $table->foreignId('loan_plan_id')->constrained()->onDelete('CASCADE');
            $table->foreignId('loan_pay_back_id')->constrained()->onDelete('CASCADE');
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
        Schema::drop('finance_vendor_services');
    }
}
