<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoanApplicationsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_applications', function (Blueprint $table) {
            $table->id('id');
            $table->string('loan_number');
            $table->string('location');
            $table->string('location_details');
            $table->string('status')->default('pending');
            $table->string('gender');
            $table->string('dob');
            $table->integer('age');
            $table->string('nok_name');
            $table->string('nok_email');
            $table->string('nok_phone');
            $table->string('nok_location');
            $table->string('nok_relationship');
            $table->string('employment_status');
            $table->string('loan_start_date')->nullable();;
            $table->string('loan_due_date')->nullable();;
            $table->string('document');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('CASCADE');
            $table->foreignId('finance_vendor_service_id')->nullable()->constrained()->onDelete('CASCADE');
            $table->foreignId('finance_vendor_category_id')->nullable()->constrained()->onDelete('CASCADE');
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
        Schema::drop('loan_applications');
    }
}
