<?php

namespace Tests\Acceptance\Auth;

use App\Models\User;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ConfirmPasswordControllerTest extends TestCase
{
    public function testShowConfirmForm()
    {
        $this->followingRedirects();
        $response = $this->call('get', route('password.confirm'));
        $response->assertSuccessful();
    }
}
