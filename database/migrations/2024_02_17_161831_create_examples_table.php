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
        if (! Schema::hasTable('examples')) {
            Schema::create('examples', function (Blueprint $table) {
                $table->id();
                $table->foreignId('resume_id')->constrained();
                $table->text('url');
                $table->text('title');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('examples');
    }
};
