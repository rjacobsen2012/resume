<?php

namespace Tests\Acceptance\Api;

use App\Models\ResumeUser;
use App\Models\User;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ResumeUserControllerTest extends TestCase
{
    public function testStore()
    {
        /** @var User $user */
        $user = factory(User::class)->create();
        Passport::actingAs($user, ['resume-user']);

        $data = [
            'name' => $this->faker->name,
            'email' => $user->email,
            'profile' => $this->faker->word,
            'phone' => $this->faker->phoneNumber,
            'github_profile' => $this->faker->url,
            'linked_in_profile' => $this->faker->url,
        ];

        $response = $this->post(
            route('api.v1.resume-user.store'),
            $data
        );
        $response->assertSuccessful();
        $response->assertJsonPath('resumeUser.name', $data['name']);
        $response->assertJsonPath('resumeUser.email', $data['email']);
        $response->assertJsonPath('resumeUser.profile', $data['profile']);
        $response->assertJsonPath('resumeUser.phone', $data['phone']);
        $response->assertJsonPath('resumeUser.github_profile', $data['github_profile']);
        $response->assertJsonPath('resumeUser.linked_in_profile', $data['linked_in_profile']);

        $data = [
            'name' => $this->faker->name,
            'email' => $user->email,
            'profile' => $this->faker->word,
            'phone' => $this->faker->phoneNumber,
            'github_profile' => $this->faker->url,
            'linked_in_profile' => $this->faker->url,
        ];

        $response = $this->post(
            route('api.v1.resume-user.store'),
            $data
        );
        $response->assertSuccessful();
        $response->assertJsonPath('resumeUser.name', $data['name']);
        $response->assertJsonPath('resumeUser.email', $data['email']);
        $response->assertJsonPath('resumeUser.profile', $data['profile']);
        $response->assertJsonPath('resumeUser.phone', $data['phone']);
        $response->assertJsonPath('resumeUser.github_profile', $data['github_profile']);
        $response->assertJsonPath('resumeUser.linked_in_profile', $data['linked_in_profile']);
    }

    public function testUpdate()
    {
        /** @var User $user */
        $user = factory(User::class)->create();

        /** @var ResumeUser $resumeUser */
        $resumeUser = factory(ResumeUser::class)->create([
            'email' => $user->email
        ]);
        Passport::actingAs($user, ['resume-user']);

        $data = [
            'name' => $this->faker->name,
            'email' => $user->email,
            'profile' => $this->faker->word,
        ];

        $response = $this->put(
            route('api.v1.resume-user.update', [$resumeUser->getKey()]),
            $data
        );
        $response->assertSuccessful();
        $response->assertJsonPath('resumeUser.name', $data['name']);
        $response->assertJsonPath('resumeUser.email', $data['email']);
        $response->assertJsonPath('resumeUser.profile', $data['profile']);
    }
}
