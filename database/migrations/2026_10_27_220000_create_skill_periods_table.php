<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * A skill is not a single number of years. It is the time actually spent using it,
 * which can stop and start again: 2000 to 2005, then 2010 to 2016.
 *
 * `skills.years` and `skills.months` are DELIBERATELY LEFT IN PLACE. Nothing reads
 * them after this change, but keeping them means a wrong backfill is recoverable.
 * They should be dropped in a later migration once the dates have been reviewed.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('skill_periods')) {
            Schema::create('skill_periods', function (Blueprint $table) {
                $table->id();
                $table->foreignId('skill_id')->constrained()->cascadeOnDelete();
                $table->date('started_on');
                // null means still in use
                $table->date('ended_on')->nullable();
                $table->timestamps();

                $table->index(['skill_id', 'started_on']);
            });
        }

        $this->backfill();
    }

    /**
     * Turn each existing years/months total into ONE open period ending today, so
     * every pill shows the same label it showed before this ran. The dates are
     * derived, not recorded, and are meant to be corrected by hand.
     */
    private function backfill(): void
    {
        if (! Schema::hasTable('skills')) {
            return;
        }

        $now = Carbon::now();

        DB::table('skills')
            ->leftJoin('skill_periods', 'skill_periods.skill_id', '=', 'skills.id')
            ->whereNull('skill_periods.id')
            ->select('skills.id', 'skills.years', 'skills.months')
            ->orderBy('skills.id')
            ->chunk(200, function ($skills) use ($now) {
                $rows = [];

                foreach ($skills as $skill) {
                    $months = ((int) $skill->years * 12) + (int) $skill->months;

                    if ($months <= 0) {
                        continue;
                    }

                    $rows[] = [
                        'skill_id' => $skill->id,
                        'started_on' => $now->copy()->subMonths($months)->toDateString(),
                        'ended_on' => null,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }

                if ($rows !== []) {
                    DB::table('skill_periods')->insert($rows);
                }
            });
    }

    public function down(): void
    {
        Schema::dropIfExists('skill_periods');
    }
};
