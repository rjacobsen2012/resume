<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * `skills.years` and `skills.months` are kept for now, so a wrong backfill of the
 * new date ranges stays recoverable. But nothing writes them any more, and they were
 * NOT NULL with no default, so every new skill failed with
 * "NOT NULL constraint failed: skills.years".
 *
 * Giving them a default of 0 lets the application ignore them while the old values
 * stay readable. They should be dropped once the dates have been reviewed.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('skills')) {
            return;
        }

        Schema::table('skills', function (Blueprint $table) {
            $table->unsignedInteger('years')->default(0)->change();
            $table->unsignedInteger('months')->default(0)->change();
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('skills')) {
            return;
        }

        Schema::table('skills', function (Blueprint $table) {
            $table->unsignedInteger('years')->default(null)->change();
            $table->unsignedInteger('months')->default(null)->change();
        });
    }
};
