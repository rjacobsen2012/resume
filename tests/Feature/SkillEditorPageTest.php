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
 * What the edit page actually hands the editor.
 *
 * ⚠️ The eager load of `skills.periods` is an N+1 FIX, NOT a correctness fix. The
 * `totals` accessor reads $this->periods, which lazy-loads it, so the data arrives
 * either way. I first wrote this class claiming the periods would be MISSING without
 * the eager load; removing it changed nothing, which is how I found out. The query
 * count is the only thing that actually moves, so that is what is asserted.
 */
class SkillEditorPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_edit_page_sends_each_skill_with_its_periods_and_label(): void
    {
        $user = User::factory()->create();
        $resume = Resume::factory()->create(['user_id' => $user->id]);

        $skill = Skill::create([
            'resume_id' => $resume->id,
            'resume_skill_id' => ResumeSkill::firstOrCreate(['name' => 'php'])->id,
        ]);

        SkillPeriod::create([
            'skill_id' => $skill->id,
            'started_on' => '2010-01-01',
            'ended_on' => '2016-01-01',
        ]);

        $this->actingAs($user)
            ->get(route('resume.edit'))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->has('resume.skills', 1)
                ->where('resume.skills.0.display', 'php: 6y')
                ->has('resume.skills.0.periods', 1)
                ->where('resume.skills.0.periods.0.started_on', fn ($v) => str_starts_with((string) $v, '2010-01-01'))
            );
    }

    /**
     * ⚠️ The eager load earns its place here: without it every skill costs its own
     * query for the periods, so the page cost grows with the number of skills.
     */
    public function test_the_periods_are_loaded_in_one_query_not_one_per_skill(): void
    {
        $user = User::factory()->create();
        $resume = Resume::factory()->create(['user_id' => $user->id]);

        foreach (['php', 'mysql', 'vue', 'laravel', 'nginx', 'redis'] as $name) {
            $skill = Skill::create([
                'resume_id' => $resume->id,
                'resume_skill_id' => ResumeSkill::firstOrCreate(['name' => $name])->id,
            ]);

            SkillPeriod::create([
                'skill_id' => $skill->id,
                'started_on' => '2015-01-01',
                'ended_on' => null,
            ]);
        }

        \Illuminate\Support\Facades\DB::enableQueryLog();

        $this->actingAs($user)->get(route('resume.edit'))->assertOk();

        $periodQueries = collect(\Illuminate\Support\Facades\DB::getQueryLog())
            ->filter(fn (array $q) => str_contains($q['query'], 'skill_periods'))
            ->count();

        \Illuminate\Support\Facades\DB::disableQueryLog();

        $this->assertLessThanOrEqual(
            1,
            $periodQueries,
            "skill_periods was queried {$periodQueries} times for 6 skills; the eager load is gone"
        );
    }

    /**
     * A skill with no dates still reaches the editor, with an empty list rather than
     * a missing key, so the "add dates" form has somewhere to sit.
     */
    public function test_a_skill_with_no_periods_still_arrives_with_an_empty_list(): void
    {
        $user = User::factory()->create();
        $resume = Resume::factory()->create(['user_id' => $user->id]);

        Skill::create([
            'resume_id' => $resume->id,
            'resume_skill_id' => ResumeSkill::firstOrCreate(['name' => 'laravel'])->id,
        ]);

        $this->actingAs($user)
            ->get(route('resume.edit'))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->where('resume.skills.0.display', 'laravel')
                ->has('resume.skills.0.periods', 0)
            );
    }
}
