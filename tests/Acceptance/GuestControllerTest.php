<?php

namespace Tests\Acceptance;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Tests\TestCase;

class GuestControllerTest extends TestCase
{
    public function testIndex()
    {
        $this->followingRedirects();
        $response = $this->call('get', route('guest'));
        $response->assertSuccessful();
        $response->assertLocation(config('app.url'));
    }

    public function testIndexLoggedIn()
    {
        /** @var User $user */
        $user = factory(User::class)->create();
        $this->followingRedirects();
        $response = $this->actingAs($user)->call('get', route('guest'));
        $response->assertSuccessful();
        $response->assertLocation(config('app.url'));
    }
}
