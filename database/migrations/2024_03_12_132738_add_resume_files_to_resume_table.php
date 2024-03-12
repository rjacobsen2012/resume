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
        if (! Schema::hasColumns('resumes', ['pdf_resume', 'word_resume'])) {
            Schema::table('resumes', function (Blueprint $table) {
                $table->string('pdf_resume')->nullable()->after('phone');
                $table->string('word_resume')->nullable()->after('phone');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumns('resumes', ['pdf_resume', 'word_resume'])) {
            Schema::table('resume', function (Blueprint $table) {
                $table->dropColumn('pdf_resume');
                $table->dropColumn('word_resume');
            });
        }
    }
};
