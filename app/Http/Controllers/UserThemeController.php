<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserThemeRequest;
use App\Models\User;

class UserThemeController extends Controller
{
    public function update(UpdateUserThemeRequest $request, User $user)
    {
        $this->authorize('update', [User::class, $user]);
        $user->update([
            'dark_theme' => $request->validated('dark_theme'),
        ]);

        return back()->with('status', 'Theme updated');
    }
}
