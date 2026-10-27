<?php

namespace Tests\Feature;

use App\Models\Resume;
use App\Models\ResumeSkill;
use App\Models\Skill;
use App\Models\SkillPeriod;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

/**
 * ⚠️ The regression test for a bug that reached production.
 *
 * `started_on` was cast as a plain date, which serialises as
 * "2003-10-27T00:00:00.000000Z". An <input type="date"> silently refuses that, and
 * the editor's formatter rendered every row as "Invalid Date". The whole skills
 * editor looked broken on the live site, and no test noticed, because every test
 * read the Carbon object rather than what the page actually sends.
 */
class SkillPeriodSerializationTest extends TestCase
{
    use RefreshDatabase;

    public function test_dates_serialise_as_plain_calendar_dates(): void
    {
        $skill = Skill::create([
            'resume_id' => Resume::factory()->create()->id,
            'resume_skill_id' => ResumeSkill::firstOrCreate(['name' => 'php'])->id,
        ]);

        $period = SkillPeriod::create([
            'skill_id' => $skill->id,
            'started_on' => '2003-10-27',
            'ended_on' => '2016-01-01',
        ]);

        $array = $period->toArray();

        $this->assertSame('2003-10-27', $array['started_on']);
        $this->assertSame('2016-01-01', $array['ended_on']);
    }

    /**
     * And the same through the page the editor actually receives, since that is what
     * the browser parses.
     */
    public function test_the_edit_page_sends_dates_an_html_date_input_accepts(): void
    {
        $user = User::factory()->create();
        $resume = Resume::factory()->create(['user_id' => $user->id]);

        $skill = Skill::create([
            'resume_id' => $resume->id,
            'resume_skill_id' => ResumeSkill::firstOrCreate(['name' => 'php'])->id,
        ]);

        SkillPeriod::create([
            'skill_id' => $skill->id,
            'started_on' => '2003-10-27',
            'ended_on' => null,
        ]);

        $this->actingAs($user)
            ->get(route('resume.edit'))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                // exactly YYYY-MM-DD, which is the only shape a date input takes
                ->where('resume.skills.0.periods.0.started_on', '2003-10-27')
                ->where('resume.skills.0.periods.0.ended_on', null)
            );
    }
}
