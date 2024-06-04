<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserThemeTest extends TestCase
{
    use RefreshDatabase;

    public function test_update_theme(): void
    {
        $this->actingAs($user = User::factory()->create());

        $this->put(route('user-theme.update', [$user->id]), [
            'dark_theme' => true,
        ])->assertRedirect(config('app.url'));
    }

    public function test_update_theme_unauthorized(): void
    {
        $otherUser = User::factory()->create();
        $this->actingAs(User::factory()->create());

        $this->put(route('user-theme.update', [$otherUser->id]), [
            'dark_theme' => true,
        ])->assertForbidden();
    }
}
