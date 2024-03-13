<?php

namespace Database\Seeders;

use App\Constant\Permissions;
use App\Constant\Roles;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

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
            $adminRole = Role::create(['name' => Roles::ADMINISTRATOR]);
            $permission = Permission::create(['name' => Permissions::MANAGE_SITE]);
            $permission->assignRole($adminRole);

            $adminUser = User::factory()->create([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email,
                'password' => bcrypt($password),
            ]);
            $adminUser->assignRole('Administrator');
        }
    }
}
