<?php

namespace Tests\Acceptance\Auth;

use App\Models\User;
use Laravel\Passport\Passport;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    public function testShowLoginForm()
    {
        /** @var User $user */
        $user = factory(User::class)->create();

        $response = $this->call('get', route('login'));
        $response->assertSuccessful();
    }

    public function testLoginLogout()
    {
        /** @var User $user */
        $user = factory(User::class)->create();

        $this->followingRedirects();
        $response = $this->call('post', route('login'), [
            'email' => $user->email,
            'password' => 'testpass'
        ]);
        $response->assertSuccessful();

        $this->followingRedirects();
        $response = $this->call('post', route('logout'));
        $response->assertSuccessful();
    }
}
