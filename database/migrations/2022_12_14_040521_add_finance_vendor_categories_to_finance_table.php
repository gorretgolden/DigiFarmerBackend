<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFinanceVendorCategoriesToFinanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('finance_vendor_services', function (Blueprint $table) {
            $table->unsignedInteger('finance_vendor_category_id')->nullable()->references('id')->on('statuses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('finance_vendor_services', function (Blueprint $table) {
            $table->dropColumn('finance_vendor_category_id');
        });
    }
}
