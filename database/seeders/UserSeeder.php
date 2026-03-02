<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
    $adminRole = Role::firstOrCreate([
        'name' => 'admin',
        'guard_name' => 'web'
    ]);

    $user = User::create([
        'name' => 'Admin',
        'email' => 'admin@gmail.com',
        'password' => bcrypt('admin123'),
    ]);

    $user->assignRole($adminRole);

    }
}
