<?php

namespace App\Http\Middleware;

use App\Cryptos\Decryptors\ResumeDecryptor;
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
        if ($user = $request->user()) {
            Inertia::share([
                'user.resume' => app(ResumeDecryptor::class)->decrypt($user->resume),
            ]);
            Inertia::share([
                'status' => session('status'),
            ]);
        }

        return $next($request);
    }
}
