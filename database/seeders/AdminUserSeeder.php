<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $firstName = config('admin.first_name');
        $lastName = config('admin.last_name');
        $email = config('admin.email');
        $password = config('admin.password');

        if (! $email) {
            $this->command->error('Please add your admin user and password to the .env');
        } else {
            $data = [
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email,
            ];

            if (! User::where($data)->first()) {
                User::factory()->create(array_merge($data, [
                    'password' => bcrypt($password),
                ]));
            }
        }
    }
}
