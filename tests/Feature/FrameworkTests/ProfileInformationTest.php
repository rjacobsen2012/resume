<?php

namespace Tests\Feature\FrameworkTests;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileInformationTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_information_can_be_updated(): void
    {
        $this->actingAs($user = User::factory()->create([
            'first_name' => $first = fake()->firstName(),
            'last_name' => $last = fake()->lastName(),
            'email' => $email = fake()->unique()->safeEmail(),
        ]));

        $response = $this->put('/user/profile-information', [
            'name' => $first . ' ' . $last,
            'email' => $email,
        ]);

        $this->assertEquals($first . ' ' . $last, $user->fresh()->name);
        $this->assertEquals($email, $user->fresh()->email);
    }
}
