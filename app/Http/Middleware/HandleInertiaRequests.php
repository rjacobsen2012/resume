<?php

namespace App\Http\Middleware;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     */
    public function share(Request $request): array
    {
        if ($user = $request->user()) {
            View::share([
                'primevueTheme' => $user->dark_theme ? 'aura-dark-blue' : 'aura-light-blue',
            ]);

            return array_merge(parent::share($request), [
                'resume' => $user->resume,
                'user' => UserResource::make($user),
                'status' => session('status'),
                'dark_theme' => $user->dark_theme,
            ]);
        }

        View::share([
            'primevueTheme' => 'aura-light-blue',
        ]);

        return array_merge(parent::share($request), [
            'resume' => null,
            'user' => null,
            'status' => session('status'),
            'dark_theme' => 'aura-light-blue',
        ]);
    }
}
