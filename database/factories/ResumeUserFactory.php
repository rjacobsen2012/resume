<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

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

$factory->define(ResumeUser::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'phone' => $faker->phoneNumber,
        'profile' => Str::title($faker->words(2, true)),
        'linked_in_profile' => $faker->url,
        'github_profile' => $faker->url,
    ];
});
