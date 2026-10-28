<?php

namespace Tests\Feature;

use App\Models\Resume;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * ⚠️ `User::resume()` is a hasOne, but `ResumePolicy::create` returned true
 * unconditionally and `store()` did `$user->resume()->create(...)`. Measured
 * 2026-10-28: posting to resume.store with a resume already present left the user
 * holding TWO rows, and hasOne then silently serves only the first one for ever.
 *
 * It was reachable in two clicks, because the nav linked to the create form from
 * every page regardless of whether the user already had a resume.
 */
class OneResumePerUserTest extends TestCase
{
    use RefreshDatabase;

    private function payload(): array
    {
        return [
            'name' => 'Second Resume',
            'email' => 'second@example.test',
            'title' => 'Imposter',
            'description' => 'x',
        ];
    }

    public function test_a_user_who_already_has_a_resume_cannot_create_another(): void
    {
        $user = User::factory()->create();
        Resume::factory()->create(['user_id' => $user->id]);

        // a premise, so the count below cannot pass on a user who had none to begin with
        $this->assertSame(1, Resume::where('user_id', $user->id)->count());

        $this->actingAs($user)->post(route('resume.store'), $this->payload());

        $this->assertSame(
            1,
            Resume::where('user_id', $user->id)->count(),
            'a second resume row was created; User::resume() is a hasOne, so it would never be shown again'
        );
    }

    public function test_the_create_page_sends_an_existing_owner_to_the_editor(): void
    {
        $user = User::factory()->create();
        Resume::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user)
            ->get(route('resume.create'))
            ->assertRedirect(route('resume.edit'));
    }

    public function test_a_user_with_no_resume_still_gets_the_create_page(): void
    {
        $user = User::factory()->create();

        $this->assertNull($user->resume);

        $this->actingAs($user)->get(route('resume.create'))->assertOk();
    }

    public function test_a_user_with_no_resume_is_sent_to_create_rather_than_forbidden(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('resume.edit'))
            ->assertRedirect(route('resume.create'));
    }

    public function test_an_owner_can_still_edit_their_own_resume(): void
    {
        $user = User::factory()->create();
        Resume::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user)->get(route('resume.edit'))->assertOk();
    }

    /**
     * The hidden flag is editable from the editor, not only at creation.
     */
    public function test_a_resume_can_be_unhidden_after_it_was_created_hidden(): void
    {
        $user = User::factory()->create();
        $resume = Resume::factory()->create(['user_id' => $user->id, 'is_hidden' => true]);

        $this->assertTrue((bool) $resume->fresh()->is_hidden);

        $this->actingAs($user)
            ->put(route('resume.update'), $this->payload() + ['is_hidden' => false])
            ->assertSessionHasNoErrors();

        $this->assertFalse((bool) $resume->fresh()->is_hidden);
    }
}
