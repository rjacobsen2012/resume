<?php

namespace App\Http\Middleware;

use App\Cryptos\Decryptors\ResumeDecryptor;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

class AuthUserLoading
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var User $user */
        $user = $request->user();
        $resume = null;

        if ($user) {
            $resume = $user->resume;
        }

        if ($resume) {
            $resume = app(ResumeDecryptor::class)->decrypt($resume);
        }

        if ($user) {
            Inertia::share([
                'user.resume' => $resume,
                'status' => session('status'),
            ]);
        }

        return $next($request);
    }
}
