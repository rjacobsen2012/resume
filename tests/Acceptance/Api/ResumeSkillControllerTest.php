<?php

namespace Tests\Acceptance\Api;

use App\Models\ResumeExperience;
use App\Models\ResumeSkill;
use App\Models\ResumeUser;
use App\Models\User;
use Carbon\Carbon;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ResumeSkillControllerTest extends TestCase
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
            'name' => $this->faker->word,
            'years' => $this->faker->randomNumber(1),
            'months' => $this->faker->randomNumber(1),
        ];

        $response = $this->post(
            route('api.v1.resume-user.resume-skill.store', [$resumeUser->getKey()]),
            $data
        );
        $response->assertSuccessful();
        $response->assertJsonPath('resumeUser.skills.0.name', $data['name']);
        $response->assertJsonPath('resumeUser.skills.0.years', $data['years']);
        $response->assertJsonPath('resumeUser.skills.0.months', $data['months']);
    }

    public function testUpdate()
    {
        /** @var User $user */
        $user = factory(User::class)->create();

        /** @var ResumeUser $resumeUser */
        $resumeUser = factory(ResumeUser::class)->create([
            'email' => $user->email
        ]);

        /** @var ResumeSkill $resumeSkill */
        $resumeSkill = factory(ResumeSkill::class)->create();

        $resumeUser->resumeSkills()->attach($resumeSkill->getKey(), [
            'years' => 2,
            'months' => 3
        ]);

        Passport::actingAs($user, ['resume-experience']);

        $data = [
            'name' => $resumeSkill->name,
            'years' => 5,
            'months' => 6,
        ];

        $response = $this->put(
            route('api.v1.resume-user.resume-skill.update', [$resumeUser->getKey(), $resumeSkill->getKey()]),
            $data
        );
        $response->assertSuccessful();
        $response->assertJsonPath('resumeUser.skills.0.name', $data['name']);
        $response->assertJsonPath('resumeUser.skills.0.years', $data['years']);
        $response->assertJsonPath('resumeUser.skills.0.months', $data['months']);

        $data = [
            'name' => $data['name'],
            'years' => 3,
            'months' => 1,
        ];

        $response = $this->put(
            route('api.v1.resume-user.resume-skill.update', [$resumeUser->getKey(), $resumeSkill->getKey()]),
            $data
        );
        $response->assertSuccessful();
        $response->assertJsonPath('resumeUser.skills.0.name', $data['name']);
        $response->assertJsonPath('resumeUser.skills.0.years', $data['years']);
        $response->assertJsonPath('resumeUser.skills.0.months', $data['months']);

        $id = $response->json('resumeUser.skills.0.id');

        $data = [
            'name' => $this->faker->word,
            'years' => 3,
            'months' => 1,
        ];

        $response = $this->put(
            route('api.v1.resume-user.resume-skill.update', [$resumeUser->getKey(), $id]),
            $data
        );
        $response->assertSuccessful();
        $response->assertJsonPath('resumeUser.skills.0.name', $data['name']);
        $response->assertJsonPath('resumeUser.skills.0.years', $data['years']);
        $response->assertJsonPath('resumeUser.skills.0.months', $data['months']);
    }

    public function testDelete()
    {
        /** @var User $user */
        $user = factory(User::class)->create();

        /** @var ResumeUser $resumeUser */
        $resumeUser = factory(ResumeUser::class)->create([
            'email' => $user->email
        ]);

        /** @var ResumeSkill $resumeSkill */
        $resumeSkill = factory(ResumeSkill::class)->create();

        $resumeUser->resumeSkills()->attach($resumeSkill->getKey(), [
            'years' => 2,
            'months' => 3
        ]);

        Passport::actingAs($user, ['resume-experience']);

        $response = $this->delete(route('api.v1.resume-user.resume-skill.destroy', [$resumeUser->getKey(), $resumeSkill->getKey()]));
        $response->assertSuccessful();
    }
}
