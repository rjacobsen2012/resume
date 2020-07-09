<?php

namespace Tests\Acceptance\Api;

use App\Models\ResumeExperience;
use App\Models\ResumeWorkExample;
use App\Models\ResumeUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ResumeWorkExampleControllerTest extends TestCase
{
    public function testStore()
    {
        /** @var User $user */
        $user = factory(User::class)->create();

        /** @var ResumeUser $resumeUser */
        $resumeUser = factory(ResumeUser::class)->create([
            'email' => $user->email
        ]);

        Passport::actingAs($user, ['resume-work-example']);

        $data = [
            'url' => $this->faker->url,
            'title' => Str::title($this->faker->words(2, true)),
        ];

        $response = $this->post(
            route('api.v1.resume-user.resume-work-example.store', [$resumeUser->getKey()]),
            $data
        );
        $response->assertSuccessful();
        $response->assertJsonPath('resumeUser.workExamples.0.url', $data['url']);
        $response->assertJsonPath('resumeUser.workExamples.0.title', $data['title']);
    }

    public function testUpdate()
    {
        /** @var User $user */
        $user = factory(User::class)->create();

        /** @var ResumeUser $resumeUser */
        $resumeUser = factory(ResumeUser::class)->create([
            'email' => $user->email
        ]);

        /** @var ResumeWorkExample $resumeWorkExample */
        $resumeWorkExample = factory(ResumeWorkExample::class)->create([
            'resume_user_id' => $resumeUser->getKey()
        ]);

        Passport::actingAs($user, ['resume-work-example']);

        $data = [
            'url' => $this->faker->url,
            'title' => Str::title($this->faker->words(2, true)),
        ];

        $response = $this->put(
            route('api.v1.resume-user.resume-work-example.update', [$resumeUser->getKey(), $resumeWorkExample->getKey()]),
            $data
        );
        $response->assertSuccessful();
        $response->assertJsonPath('resumeUser.workExamples.0.url', $data['url']);
        $response->assertJsonPath('resumeUser.workExamples.0.title', $data['title']);
    }

    public function testDelete()
    {
        /** @var User $user */
        $user = factory(User::class)->create();

        /** @var ResumeUser $resumeUser */
        $resumeUser = factory(ResumeUser::class)->create([
            'email' => $user->email
        ]);

        /** @var ResumeWorkExample $resumeWorkExample */
        $resumeWorkExample = factory(ResumeWorkExample::class)->create([
            'resume_user_id' => $resumeUser->getKey()
        ]);

        Passport::actingAs($user, ['resume-work-example']);

        $response = $this->delete(route('api.v1.resume-user.resume-work-example.destroy', [$resumeUser->getKey(), $resumeWorkExample->getKey()]));
        $response->assertSuccessful();
    }
}
