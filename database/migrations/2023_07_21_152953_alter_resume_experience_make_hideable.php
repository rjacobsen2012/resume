<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterResumeExperienceMakeHideable extends Migration
{
    public function up()
    {
        Schema::table('resume_experiences', function (Blueprint $table) {
            $table->boolean('hidden')
                ->default(false);
        });
    }

    public function down()
    {
        Schema::table('facility', function (Blueprint $table) {
            $table->dropColumn('hidden');
        });
    }
}
