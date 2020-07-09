<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ResumeExperience;
use App\Models\ResumeUser;
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

$factory->define(ResumeExperience::class, function (Faker $faker) {
    return [
        'resume_user_id' => factory(ResumeUser::class),
        'company_name' => Str::title($faker->words(2, true)),
        'title' => Str::title($faker->words(2, true)),
        'city' => $faker->city,
        'state' => $faker->state,
        'started_at' => \Carbon\Carbon::now()->subYear(),
        'ended_at' => \Carbon\Carbon::yesterday(),
        'present' => 0,
        'description' => $faker->sentence
    ];
});
