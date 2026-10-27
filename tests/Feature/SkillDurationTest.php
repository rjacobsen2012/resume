<?php

namespace Tests\Feature;

use App\Models\Resume;
use App\Models\ResumeSkill;
use App\Models\Skill;
use App\Models\SkillPeriod;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

/**
 * A skill's label is the total time it was actually in use, across however many
 * stretches, formatted short: 12d, 7m, 23y.
 */
class SkillDurationTest extends TestCase
{
    use RefreshDatabase;

    private function skill(string $name = 'php'): Skill
    {
        $resume = Resume::factory()->create();

        return Skill::create([
            'resume_id' => $resume->id,
            'resume_skill_id' => ResumeSkill::firstOrCreate(['name' => $name])->id,
            'years' => 0,
            'months' => 0,
        ]);
    }

    private function period(Skill $skill, string $from, ?string $to): void
    {
        SkillPeriod::create([
            'skill_id' => $skill->id,
            'started_on' => $from,
            'ended_on' => $to,
        ]);
    }

    public function test_separate_periods_add_up(): void
    {
        $skill = $this->skill();
        $this->period($skill, '2000-01-01', '2005-01-01');   // 5 years
        $this->period($skill, '2010-01-01', '2016-01-01');   // 6 years

        $this->assertSame('php: 11y', $skill->fresh()->display);
    }

    /**
     * ⚠️ The rule that stops every total being quietly inflated. Adding these two
     * separately would give 12 years for 8 years of actually using the skill.
     */
    public function test_overlapping_periods_are_merged_not_added(): void
    {
        $skill = $this->skill();
        $this->period($skill, '2010-01-01', '2016-01-01');
        $this->period($skill, '2014-01-01', '2018-01-01');

        $this->assertSame('php: 8y', $skill->fresh()->display);
    }

    /**
     * An open period runs to today, not for ever.
     */
    public function test_an_open_period_counts_up_to_today(): void
    {
        Carbon::setTestNow('2026-01-01');

        $skill = $this->skill();
        $this->period($skill, '2020-01-01', null);

        $this->assertSame('php: 6y', $skill->fresh()->display);

        Carbon::setTestNow();
    }

    /**
     * ⚠️ 1 January to 1 August is SEVEN calendar months. The first version of this
     * test asserted 6m, because the code divided 213 days by an average month and
     * got 6.99. The test was encoding the bug.
     */
    public function test_months_are_shown_under_a_year(): void
    {
        $skill = $this->skill();
        $this->period($skill, '2020-01-01', '2020-08-01');

        $this->assertSame('php: 7m', $skill->fresh()->display);
    }

    /**
     * ⚠️ The regression test for what the real data exposed: an exact span of whole
     * years must not come out a year short. 17 years is 6208 days, and dividing by
     * 365.25 gives 16.99, which floors to 16. Measured on 2026-10-27: 14 of 25 real
     * skills lost a year that way.
     */
    public function test_an_exact_run_of_years_is_not_a_year_short(): void
    {
        $skill = $this->skill();
        $this->period($skill, '2009-01-01', '2026-01-01');

        $this->assertSame('php: 17y', $skill->fresh()->display);
    }

    public function test_days_are_shown_under_a_month(): void
    {
        $skill = $this->skill();
        $this->period($skill, '2020-01-01', '2020-01-13');

        $this->assertSame('php: 12d', $skill->fresh()->display);
    }

    /**
     * No periods means no number, exactly as zero years and months always did.
     */
    public function test_a_skill_with_no_periods_shows_only_its_name(): void
    {
        $this->assertSame('php', $this->skill()->fresh()->display);
    }

    /**
     * ⚠️ The label must come from the PERIODS, not the legacy columns. Those still
     * exist so a bad backfill stays recoverable, and nothing should read them.
     */
    public function test_the_legacy_years_column_is_ignored(): void
    {
        $skill = $this->skill();
        $skill->update(['years' => 99, 'months' => 11]);
        $this->period($skill, '2020-01-01', '2022-01-01');

        $this->assertSame('php: 2y', $skill->fresh()->display);
    }

    /**
     * Bad data must not produce negative time.
     */
    public function test_a_period_ending_before_it_starts_is_ignored(): void
    {
        $skill = $this->skill();
        $this->period($skill, '2020-01-01', '2019-01-01');

        $this->assertSame('php', $skill->fresh()->display);
    }

    /**
     * Deleting a skill takes its periods with it rather than orphaning rows.
     */
    public function test_periods_go_when_the_skill_goes(): void
    {
        $skill = $this->skill();
        $this->period($skill, '2020-01-01', null);

        $skill->delete();

        $this->assertDatabaseCount('skill_periods', 0);
    }
}
