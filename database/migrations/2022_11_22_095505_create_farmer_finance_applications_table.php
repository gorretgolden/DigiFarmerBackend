<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFarmerFinanceApplicationsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('farmer_finance_applications', function (Blueprint $table) {
            $table->id('id');
            $table->boolean('is_approved')->default(false);
            $table->string('national_id')->nullable();
            $table->string('driving_permit')->nullable();;
            $table->string('land_title')->nullable();
            $table->foreignId('finance_vendor_service_id')->constrained()->onDelete('CASCADE');
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
        Schema::drop('farmer_finance_applications');
    }
}
