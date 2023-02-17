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
            $table->integer('principal');
            $table->integer('interest_rate');
            $table->string('interest_rate_unit')->default('%');
            $table->integer('payment_frequency_pay')->default(0);
            $table->integer('simple_interest')->default(0);
            $table->boolean('is_verified')->default(false);
            $table->integer('total_amount_paid_back')->default(0);
            $table->string('location');
            $table->string('document_type');
            $table->text('terms');
            $table->enum('loan_pay_back',['Daily','Weekly','Monthly'])->default('Monthly');
            $table->string('image')->nullable();
            $table->foreignId('vendor_category_id')->constrained()->onDelete('CASCADE');
            $table->foreignId('loan_plan_id')->constrained()->onDelete('CASCADE');
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
