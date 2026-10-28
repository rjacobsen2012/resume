<?php

namespace Tests\Feature;

use App\Models\Resume;
use App\Models\ResumeSkill;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

/**
 * ⚠️ `resume.edit` is declared as `resume/edit` and takes NO parameters, but every
 * save redirected with `route('resume.edit', [$resume->id])`. Laravel does not drop
 * a parameter a route has no slot for, it appends it as a QUERY STRING, so saving
 * anything left the address bar reading `/resume/edit?2=`.
 *
 * Nothing broke, which is exactly why it survived: it is only visible in the URL.
 */
class CleanRedirectTest extends TestCase
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

    /**
     * The route itself, with no caller involved.
     */
    public function test_the_edit_route_url_carries_no_query_string(): void
    {
        $this->assertStringNotContainsString('?', route('resume.edit'));
    }

    /**
     * @return array<string, array{string, string, array<string, mixed>}>
     */
    public static function savesThatRedirectToTheEditor(): array
    {
        return [
            'add a skill' => ['post', 'resume.skill.store', ['name' => 'laravel']],
            'add a date range' => ['post', 'resume.skill.period.store', ['started_on' => '2010-01-01']],
            'add an education' => ['post', 'resume.education.store', [
                'school' => 'Indiana University',
                'city' => 'Bloomington',
                'state' => 'Indiana',
                'description' => 'Compilers.',
            ]],
            'add an experience' => ['post', 'resume.experience.store', [
                'company_name' => 'Acme',
                'title' => 'Engineer',
                'city' => 'Louisville',
                'state' => 'Kentucky',
                'started_at' => '2018-03-01',
                'description' => 'Testing.',
            ]],
            'add an example' => ['post', 'resume.example.store', [
                'title' => 'A site',
                'url' => 'https://example.test',
            ]],
        ];
    }

    /**
     * @param  array<string, mixed>  $payload
     */
    #[DataProvider('savesThatRedirectToTheEditor')]
    public function test_a_save_redirects_to_a_clean_editor_url(string $verb, string $route, array $payload): void
    {
        $parameters = $route === 'resume.skill.period.store'
            ? [$this->resume->id, $this->skill->id]
            : [$this->resume->id];

        $response = $this->actingAs($this->user)
            ->{$verb}(route($route, $parameters), $payload);

        $response->assertSessionHasNoErrors();

        $target = $response->headers->get('Location');

        // a premise, so this cannot pass on a response that redirected nowhere
        $this->assertNotNull($target, "{$route} did not redirect at all");

        $this->assertStringNotContainsString(
            '?',
            $target,
            "{$route} redirected to {$target}; resume.edit takes no parameters, so an id "
            .'passed to it is appended as a query string'
        );
        $this->assertSame(route('resume.edit'), $target);
    }
}
