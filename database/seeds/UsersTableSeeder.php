<?php

use App\Models\Role;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Testing\WithFaker;

class UsersTableSeeder extends Seeder
{
    use WithFaker;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        $firstName = config('resume.admin-first-name') ?: $faker->firstName;
        $lastName = config('resume.admin-last-name') ?: $faker->lastName;
        $email = config('resume.admin-email') ?: $faker->safeEmail;
        $password = bcrypt($rawPassword = config('resume.admin-password', 'secret'));

        $this->command->info(
            'Be sure to set the following values in your .env' . PHP_EOL .
            '===> RESUME_FIRST_NAME=' . $firstName . PHP_EOL .
            '===> RESUME_LAST_NAME=' . $lastName . PHP_EOL .
            '===> RESUME_EMAIL=' . $email . PHP_EOL .
            '===> RESUME_PASSWORD=' . $rawPassword . PHP_EOL
        );

        /** @var User $user */
        $user = User::where('email', $email)->first();

        if (! $user) {
            $user = User::create([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email,
                'password' => $password,
            ]);
        }

        $user->roles()->sync(Role::admin()->first()->id);
    }
}
