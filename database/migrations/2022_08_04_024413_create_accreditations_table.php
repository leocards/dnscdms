<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccreditationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accreditations', function (Blueprint $table) {
            $table->id();
            $table->string('unique', 500)->unique()->nullable();
            $table->string('title', 500)->index();
            $table->string('set', 150)->index()->nullable();
            $table->string('parent')->nullable();
            $table->string('description', 1500)->index()->nullable();
            $table->string('category', 20)->nullable();
            $table->date('date_survey')->nullable();
            $table->string('status', 50)->nullable();
            $table->string('progress', 50)->nullable();
            $table->unsignedBigInteger('program_id');
            $table->unsignedBigInteger('ExternalRate_id')->nullable();
            $table->unsignedBigInteger('InternalRate_id')->nullable();
            $table->foreign('program_id')->references('id')->on('programs');
            $table->foreign('InternalRate_id')->references('id')->on('internal_rates');
            $table->foreign('ExternalRate_id')->references('id')->on('external_rates');
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
        Schema::dropIfExists('accreditations');
    }
}
