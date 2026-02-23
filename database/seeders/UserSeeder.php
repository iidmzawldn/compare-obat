<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ADMIN
        $admin = User::firstOrCreate(
            ['email' => 'admin@local.test'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
            ]
        );
        $admin->assignRole('admin');


        // FARMASI
        $farmasi = User::firstOrCreate(
            ['email' => 'farmasi@local.test'],
            [
                'name' => 'Farmasi',
                'password' => Hash::make('password'),
            ]
        );
        $farmasi->assignRole('farmasi');


        // VENDOR
        $vendor = User::firstOrCreate(
            ['email' => 'vendor@local.test'],
            [
                'name' => 'Vendor',
                'password' => Hash::make('password'),
            ]
        );
        $vendor->assignRole('vendor');


        // MANAJEMEN
        $manajemen = User::firstOrCreate(
            ['email' => 'manajemen@local.test'],
            [
                'name' => 'Manajemen',
                'password' => Hash::make('password'),
            ]
        );
        $manajemen->assignRole('manajemen');
    }
}
