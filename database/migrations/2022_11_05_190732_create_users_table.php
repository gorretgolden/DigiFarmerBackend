<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('image_url')->nullable();
            $table->string('phone');
            $table->enum('user_type',['admin','farmer','seller','vendor','delivery-man'])->default('farmer');
            $table->foreignId('country_id')->nullable()->constrained()->onDelete('CASCADE');
            $table->string('password')->nullable();
            $table->string('google_id')->unique()->nullable();
            $table->string('facebook_id')->unique()->nullable();
            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
