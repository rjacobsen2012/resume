<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResumeEducationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resume_educations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('resume_user_id');
            $table->string('school');
            $table->string('city');
            $table->string('state');
            $table->string('degree')->nullable();
            $table->dateTime('started_at')->default(null)->nullable();
            $table->dateTime('ended_at')->default(null)->nullable();
            $table->longText('description');
            $table->timestamps();

            $table->foreign('resume_user_id')->references('id')->on('resume_users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resume_educations');
    }
}
