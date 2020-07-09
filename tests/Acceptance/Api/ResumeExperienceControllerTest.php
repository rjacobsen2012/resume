<?php

namespace Tests\Acceptance\Api;

use App\Models\ResumeExperience;
use App\Models\ResumeUser;
use App\Models\User;
use Carbon\Carbon;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ResumeExperienceControllerTest extends TestCase
{
    public function testStore()
    {
        /** @var User $user */
        $user = factory(User::class)->create();

        /** @var ResumeUser $resumeUser */
        $resumeUser = factory(ResumeUser::class)->create([
            'email' => $user->email
        ]);

        Passport::actingAs($user, ['resume-experience']);

        $data = [
            'company_name' => $this->faker->word,
            'title' => $this->faker->words(3, true),
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'started_at' => Carbon::now()->subYear(),
            'ended_at' => Carbon::now(),
            'present' => 0,
            'description' => $this->faker->sentence,
        ];

        $response = $this->post(
            route('api.v1.resume-user.resume-experience.store', [$resumeUser->getKey()]),
            $data
        );
        $response->assertSuccessful();
        $response->assertJsonPath('resumeUser.experiences.0.company_name', $data['company_name']);
        $response->assertJsonPath('resumeUser.experiences.0.title', $data['title']);
        $response->assertJsonPath('resumeUser.experiences.0.city', $data['city']);
        $response->assertJsonPath('resumeUser.experiences.0.state', $data['state']);
        $response->assertJsonPath('resumeUser.experiences.0.present', false);
        $response->assertJsonPath('resumeUser.experiences.0.started_at', $data['started_at']->format('Y-m-d'));
        $response->assertJsonPath('resumeUser.experiences.0.ended_at', $data['ended_at']->format('Y-m-d'));
        $response->assertJsonPath('resumeUser.experiences.0.description', $data['description']);
    }

    public function testUpdate()
    {
        /** @var User $user */
        $user = factory(User::class)->create();

        /** @var ResumeUser $resumeUser */
        $resumeUser = factory(ResumeUser::class)->create([
            'email' => $user->email
        ]);

        /** @var ResumeExperience $resumeExperience */
        $resumeExperience = factory(ResumeExperience::class)->create([
            'resume_user_id' => $resumeUser->getKey()
        ]);

        Passport::actingAs($user, ['resume-experience']);

        $data = [
            'company_name' => $this->faker->word,
            'title' => $this->faker->words(3, true),
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'started_at' => Carbon::now()->subYear(),
            'ended_at' => Carbon::now(),
            'present' => 0,
            'description' => $this->faker->sentence,
        ];

        $response = $this->put(
            route('api.v1.resume-user.resume-experience.update', [$resumeUser->getKey(), $resumeExperience->getKey()]),
            $data
        );
        $response->assertSuccessful();
        $response->assertJsonPath('resumeUser.experiences.0.company_name', $data['company_name']);
        $response->assertJsonPath('resumeUser.experiences.0.title', $data['title']);
        $response->assertJsonPath('resumeUser.experiences.0.city', $data['city']);
        $response->assertJsonPath('resumeUser.experiences.0.state', $data['state']);
        $response->assertJsonPath('resumeUser.experiences.0.present', false);
        $response->assertJsonPath('resumeUser.experiences.0.started_at', $data['started_at']->format('Y-m-d'));
        $response->assertJsonPath('resumeUser.experiences.0.ended_at', $data['ended_at']->format('Y-m-d'));
        $response->assertJsonPath('resumeUser.experiences.0.description', $data['description']);
    }

    public function testDelete()
    {
        /** @var User $user */
        $user = factory(User::class)->create();

        /** @var ResumeUser $resumeUser */
        $resumeUser = factory(ResumeUser::class)->create([
            'email' => $user->email
        ]);

        /** @var ResumeExperience $resumeExperience */
        $resumeExperience = factory(ResumeExperience::class)->create([
            'resume_user_id' => $resumeUser->getKey()
        ]);

        Passport::actingAs($user, ['resume-experience']);

        $response = $this->delete(route('api.v1.resume-user.resume-experience.destroy', [$resumeUser->getKey(), $resumeExperience->getKey()]));
        $response->assertSuccessful();
    }
}
