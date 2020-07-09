<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResumeWorkExamplesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resume_work_examples', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('resume_user_id');
            $table->string('url');
            $table->string('title');
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
        Schema::dropIfExists('resume_work_examples');
    }
}
