<?php

namespace Database\Seeders;

use App\Constant\Permissions;
use App\Constant\Roles;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            $adminRole = Role::firstOrCreate(['name' => Roles::ADMINISTRATOR]);
            $permission = Permission::firstOrCreate(['name' => Permissions::MANAGE_SITE]);
            $permission->assignRole($adminRole);

            $adminUser = User::where([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email,
            ])->first();

            $adminUser = $adminUser ?: User::factory()->create([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email,
                'password' => bcrypt($password)
            ]);

            $adminUser->assignRole('Administrator');
        }
    }
}
