<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_services', function (Blueprint $table) {
            $table->id();
            $table->string('name',200)->unique();
            $table->string('image')->nullable();
            $table->string('price_unit')->default('UGX');
            $table->string('charge_unit')->nullable();
            $table->integer('price')->nullable();
            $table->text('description');
            $table->string('weight')->nullable();
            $table->string('weight_unit')->nullable();
            $table->integer('stock_amount')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->text('expertise',255)->nullable();
            $table->integer('charge')->nullable();
            $table->string('charge_frequency')->nullable();
            $table->text('zoom_details')->nullable();
            $table->string('location')->nullable();
            $table->string('starting_date')->nullable();
            $table->string('ending_date')->nullable();
            $table->string('starting_time')->nullable();
            $table->string('ending_time')->nullable();
            $table->integer('principal')->nullable();
            $table->integer('interest_rate')->nullable();
            $table->string('interest_rate_unit')->nullable();
            $table->integer('payment_frequency_pay')->nullable();
            $table->integer('simple_interest')->nullable();
            $table->string('status')->nullable();
            $table->integer('total_amount_paid_back')->nullable();
            $table->string('document_type')->nullable();
            $table->text('terms')->nullable();
            $table->enum('loan_pay_back',['Daily','Weekly','Monthly'])->nullable();
            $table->enum('access',['chat','online','call','in-person'])->nullable();
            $table->foreignId('loan_plan_id')->nullable()->constrained()->onDelete('CASCADE');
            $table->foreignId('sub_category_id')->nullable()->constrained()->onDelete('CASCADE');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('CASCADE');
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
        Schema::dropIfExists('vendor_services');
    }
}
