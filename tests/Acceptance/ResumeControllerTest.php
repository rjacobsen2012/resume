<?php

namespace Tests\Acceptance;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Tests\TestCase;

class ResumeControllerTest extends TestCase
{
    public function testIndex()
    {
        /** @var User $user */
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)
            ->call('get', route('resume.index'));
        $response->assertSuccessful();
    }

    public function testDownloadResume()
    {
        /** @var User $user */
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)
            ->call('get', route('resume-user.download-resume'));
        $response->assertSuccessful();
    }
}
