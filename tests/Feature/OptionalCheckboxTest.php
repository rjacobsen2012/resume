<?php

namespace Tests\Feature;

use App\Models\Resume;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * ⚠️ `is_hidden` and `present` are `nullable` in the form requests, so a payload that
 * omits them is VALID input. The controllers then read `$validated['is_hidden']`
 * directly, and an absent key is an "Undefined array key" warning, which Laravel
 * turns into an ErrorException: a 500 on input the validator just approved.
 *
 * The browser never showed it because the Vue forms always send both checkboxes.
 * Anything else posting to these endpoints got a 500.
 */
class OptionalCheckboxTest extends TestCase
{
    use RefreshDatabase;

    private function basicExperience(): array
    {
        return [
            'company_name' => 'Acme Testing Co',
            'title' => 'Engineer',
            'city' => 'Louisville',
            'state' => 'Kentucky',
            'started_at' => '2018-03-01',
            'description' => 'Testing.',
        ];
    }

    public function test_an_experience_can_be_added_without_the_optional_checkboxes(): void
    {
        $user = User::factory()->create();
        $resume = Resume::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user)
            ->post(route('resume.experience.store', [$resume->id]), $this->basicExperience())
            ->assertSessionHasNoErrors()
            ->assertRedirect();

        $experience = $resume->experiences()->first();

        $this->assertNotNull($experience, 'the experience was not created');
        $this->assertFalse((bool) $experience->is_hidden);
        $this->assertFalse((bool) $experience->present);
    }

    public function test_an_experience_can_be_updated_without_the_optional_checkboxes(): void
    {
        $user = User::factory()->create();
        $resume = Resume::factory()->create(['user_id' => $user->id]);

        $experience = $resume->experiences()->create(
            $this->basicExperience() + ['is_hidden' => true, 'present' => true]
        );

        // a premise, so the assertions below cannot pass on a record that was already false
        $this->assertTrue((bool) $experience->fresh()->is_hidden);

        $this->actingAs($user)
            ->put(
                route('resume.experience.update', [$resume->id, $experience->id]),
                $this->basicExperience()
            )
            ->assertSessionHasNoErrors()
            ->assertRedirect();

        $this->assertFalse((bool) $experience->fresh()->is_hidden);
        $this->assertFalse((bool) $experience->fresh()->present);
    }
}
