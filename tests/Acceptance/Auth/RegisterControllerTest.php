<?php

namespace Tests\Acceptance\Auth;

use App\Models\User;
use Laravel\Passport\Passport;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    public function testShowRegistrationForm()
    {
        $response = $this->call('get', route('register'));
        $response->assertSuccessful();
    }

    public function testLoginLogout()
    {
        $this->followingRedirects();
        $response = $this->call('post', '/register', [
            'first_name' => 'Joe',
            'last_name' => 'Schmoe',
            'email' => 'joe.schmoe@example.com',
            'password' => 'testpass',
            'password_confirmation' => 'testpass'
        ]);
        $response->assertSuccessful();
    }
}
