<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasTable('educations')) {
            Schema::create('educations', function (Blueprint $table) {
                $table->id();
                $table->foreignId('resume_id')->constrained();
                $table->string('school');
                $table->string('city');
                $table->string('state');
                $table->string('degree')->nullable();
                $table->dateTime('started_at')->default(null)->nullable();
                $table->dateTime('ended_at')->default(null)->nullable();
                $table->longText('description');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('educations');
    }
};
