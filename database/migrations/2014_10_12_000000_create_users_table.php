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
            $table->id();
            $table->string('lname')->index();
            $table->string('fname')->index();
            $table->string('email')->unique();
            $table->string('password')->index();
            $table->unsignedBigInteger('designationId');
            $table->unsignedBigInteger('instituteId');
            $table->unsignedBigInteger('programId')->nullable();
            $table->foreign('designationId')->references('id')->on('designations');
            $table->foreign('instituteId')->references('id')->on('institutes');
            $table->foreign('programId')->references('id')->on('programs');
            $table->string('image')->index()->nullable();
            $table->string('status')->nullable();
            $table->string('theme')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
