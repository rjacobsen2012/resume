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
        if (! Schema::hasTable('experiences')) {
            Schema::create('experiences', function (Blueprint $table) {
                $table->id();
                $table->foreignId('resume_id')->constrained();
                $table->text('company_name');
                $table->text('title');
                $table->text('city');
                $table->text('state');
                $table->dateTime('started_at')->default(null)->nullable();
                $table->dateTime('ended_at')->default(null)->nullable();
                $table->boolean('present')->default(0);
                $table->longText('description');
                $table->boolean('is_hidden')->default(false);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('experiences');
    }
};
