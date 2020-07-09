<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ResumeUser;
use App\Models\ResumeWorkExample;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(ResumeWorkExample::class, function (Faker $faker) {
    return [
        'resume_user_id' => factory(ResumeUser::class),
        'url' => $faker->url,
        'title' => Str::title($faker->words(2, true)),
    ];
});
