<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->mediumText('description');
            $table->string('parentVersion')->nullable()->index();
            $table->string('action')->nullable();//removed or not
            $table->string('verdict')->nullable();//approve or rejecte or revise
            $table->string('version')->nullable()->index();//current/old version
            $table->unsignedBigInteger('modifiedBy');
            $table->unsignedBigInteger('accredId');
            $table->foreign('modifiedBy')->references('id')->on('users');
            $table->foreign('accredId')->references('id')->on('accreditations');
            $table->timestamps();
        });

        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('filename')->index();
            $table->string('version')->nullable()->index();
            $table->unsignedBigInteger('documentId');
            $table->foreign('documentId')->references('id')->on('documents');
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
        Schema::dropIfExists('documents');
        Schema::dropIfExists('files');
    }
}
