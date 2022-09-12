<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userId');
            $table->unsignedBigInteger('area')->nullable();
            $table->unsignedBigInteger('accredId')->nullable();
            $table->unsignedBigInteger('programId');
            $table->string('parent', 50)->nullable();
            $table->string('role', 50)->nullable();
            $table->string('action', 50)->nullable();
            $table->string('status', 50)->nullable();
            $table->date('dueDate')->nullable();
            $table->time('dueTime')->nullable();
            $table->foreign('programId')->references('id')->on('programs');
            $table->foreign('area')->references('id')->on('accreditations');
            $table->foreign('accredId')->references('id')->on('accreditations');
            $table->foreign('userId')->references('id')->on('users');
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
        Schema::dropIfExists('tasks');
    }
}
