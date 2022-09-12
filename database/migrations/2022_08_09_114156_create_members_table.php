<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userId');
            $table->unsignedBigInteger('designationId');
            $table->unsignedBigInteger('instituteId');
            $table->unsignedBigInteger('programId')->nullable();
            $table->foreign('userId')->references('id')->on('users');
            $table->foreign('designationId')->references('id')->on('designations');
            $table->foreign('instituteId')->references('id')->on('institutes');
            $table->foreign('programId')->references('id')->on('programs');
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
        Schema::dropIfExists('members');
    }
}
