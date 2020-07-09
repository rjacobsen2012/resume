<?php

use App\Http\Resources\ResumeUserResource;
use App\Models\ResumeSkill;
use App\Models\ResumeUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

if (! function_exists('component')) {
    /**
     * Similar to view(), but instead of taking the name of a blade template,
     * it takes the name of a registered Vue component. Data passed in will
     * be passed to the component as its props.
     *
     * @param string $name
     * @param array $data
     * @return \Inertia\Response
     */
    function component($name, $data = [])
    {
        return Inertia::render($name, $data);
    }
}

if (! function_exists('authLogout')) {
    /**
     * @return JsonResponse|RedirectResponse
     */
    function authLogout()
    {
        Auth::logout();

        session()->invalidate();

        return loggedOut() ?: redirect()->to('/');
    }
}

if (! function_exists('loggedOut')) {
    function loggedOut()
    {
        return null;
    }
}

if (! function_exists('user')) {
    /**
     * Return an instance of the currently authenticated user model.
     *
     * @return User|\Illuminate\Contracts\Auth\Authenticatable|null
     */
    function user()
    {
        return auth()->user();
    }
}

if (! function_exists('resumeUser')) {
    /**
     * @return ResumeUserResource|null
     */
    function resumeUser()
    {
        /** @var string $email */
        $email = config('resume.email');

        $resumeUser = $email ? ResumeUser::where('email', $email)->first() : null;
        return $resumeUser ?
            new ResumeUserResource(
                $resumeUser->loadMissing(['resumeSkills', 'resumeExperiences', 'resumeWorkExamples'])
            ) :
            null;
    }
}

if (! function_exists('skill')) {
    /**
     * @param string $name
     * @return ResumeSkill|Model
     */
    function skill(string $name)
    {
        return ResumeSkill::firstOrCreate(['name' => $name]);
    }
}

if (! function_exists('catch_and_return')) {
    /**
     * @param $message
     * @param Exception $exception
     * @param bool $showStackTrace
     * @param bool $showTime
     * @return string
     */
    function catch_and_return($message, Exception $exception, $showStackTrace = true, $showTime = true)
    {
        $time = now()->toDateTimeString();
        $message = $showTime ? "{$time}: {$message}" : $message;
        if ($showStackTrace) {
            Log::critical($message . PHP_EOL .
                $exception->getMessage() . PHP_EOL . $exception->getTraceAsString());
        } else {
            Log::critical($message . PHP_EOL . $exception->getMessage());
        }
        return $message;
    }
}
