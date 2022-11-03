<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksRemindersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks_reminders', function (Blueprint $table) {
            $table->id();
            $table->date('reminder_date');
            $table->integer('number_of_times');
            $table->enum('units',['Per Day','Per Week','Per Month','Per Year']);
            $table->foreignId('task_id')->nullable()->constrained()->onDelete('CASCADE');
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
        Schema::dropIfExists('tasks_reminders');
    }
}
