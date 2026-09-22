<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // 1. Get all permissions
        $permissions = Permission::all();

        // 2. Create or get Admin role
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);

        // 3. Assign ALL permissions to Admin role
        $adminRole->syncPermissions($permissions);

        // 4. Create Admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'raw_password' => 'password',
                'status' => 'Active',
                'email_verified_at' => now(),
            ]
        );

        // 5. Assign role to user
        $admin->assignRole($adminRole);
    }
}