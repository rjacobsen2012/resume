<?php

namespace Tests\Feature;

use App\Models\Resume;
use App\Models\ResumeSkill;
use App\Models\Skill;
use App\Models\SkillPeriod;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Adding and removing the date ranges on a skill.
 */
class SkillPeriodEndpointTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    private Resume $resume;

    private Skill $skill;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->resume = Resume::factory()->create(['user_id' => $this->user->id]);
        $this->skill = Skill::create([
            'resume_id' => $this->resume->id,
            'resume_skill_id' => ResumeSkill::firstOrCreate(['name' => 'php'])->id,
        ]);
    }

    public function test_a_range_can_be_added(): void
    {
        $this->actingAs($this->user)
            ->post(route('resume.skill.period.store', [$this->resume->id, $this->skill->id]), [
                'started_on' => '2010-01-01',
                'ended_on' => '2016-01-01',
            ])
            ->assertSessionHasNoErrors();

        $this->assertSame(1, $this->skill->periods()->count());
        $this->assertSame('php: 6y', $this->skill->fresh()->display);
    }

    /**
     * An empty end date means the skill is still in use, not a missing value.
     */
    public function test_an_open_range_is_stored_as_null(): void
    {
        $this->actingAs($this->user)
            ->post(route('resume.skill.period.store', [$this->resume->id, $this->skill->id]), [
                'started_on' => '2020-01-01',
                'ended_on' => '',
            ])
            ->assertSessionHasNoErrors();

        $this->assertNull($this->skill->periods()->first()->ended_on);
    }

    public function test_several_ranges_can_be_added_to_one_skill(): void
    {
        foreach ([['2000-01-01', '2005-01-01'], ['2010-01-01', '2016-01-01']] as [$from, $to]) {
            $this->actingAs($this->user)
                ->post(route('resume.skill.period.store', [$this->resume->id, $this->skill->id]), [
                    'started_on' => $from,
                    'ended_on' => $to,
                ]);
        }

        $this->assertSame(2, $this->skill->periods()->count());
        $this->assertSame('php: 11y', $this->skill->fresh()->display);
    }

    public function test_an_end_before_the_start_is_rejected(): void
    {
        $this->actingAs($this->user)
            ->post(route('resume.skill.period.store', [$this->resume->id, $this->skill->id]), [
                'started_on' => '2016-01-01',
                'ended_on' => '2010-01-01',
            ])
            ->assertSessionHasErrors('ended_on');

        $this->assertSame(0, $this->skill->periods()->count());
    }

    public function test_a_range_can_be_removed(): void
    {
        $period = SkillPeriod::create([
            'skill_id' => $this->skill->id,
            'started_on' => '2010-01-01',
            'ended_on' => '2016-01-01',
        ]);

        $this->actingAs($this->user)
            ->delete(route('resume.skill.period.destroy', [$this->resume->id, $this->skill->id, $period->id]))
            ->assertSessionHasNoErrors();

        $this->assertSame(0, $this->skill->periods()->count());
    }

    /**
     * ⚠️ A period id belonging to a DIFFERENT skill must not be deletable just
     * because the URL names a skill the caller owns.
     */
    public function test_a_period_from_another_skill_cannot_be_deleted(): void
    {
        $otherSkill = Skill::create([
            'resume_id' => $this->resume->id,
            'resume_skill_id' => ResumeSkill::firstOrCreate(['name' => 'mysql'])->id,
        ]);

        $foreign = SkillPeriod::create([
            'skill_id' => $otherSkill->id,
            'started_on' => '2010-01-01',
            'ended_on' => null,
        ]);

        $this->actingAs($this->user)
            ->delete(route('resume.skill.period.destroy', [$this->resume->id, $this->skill->id, $foreign->id]))
            ->assertNotFound();

        $this->assertDatabaseHas('skill_periods', ['id' => $foreign->id]);
    }

    /**
     * ⚠️ A skill is created with NO ranges. That is the whole point of the flow.
     */
    public function test_a_new_skill_starts_with_no_ranges(): void
    {
        $this->actingAs($this->user)
            ->post(route('resume.skill.store', [$this->resume->id]), ['name' => 'laravel'])
            ->assertSessionHasNoErrors();

        $skill = Skill::query()->whereRelation('resumeSkill', 'name', 'laravel')->firstOrFail();

        $this->assertSame(0, $skill->periods()->count());
        $this->assertSame('laravel', $skill->display);
    }
}
