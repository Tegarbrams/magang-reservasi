<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        DB::table('users')->insert([
            'name' => 'Admin Utama',
            'email' => 'admin@example.com',
            'no_hp' => '081234567890',
            'password' => Hash::make('qwerty'), // ganti sesuai kebutuhan
            'role' => 1, // admin
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // User Biasa
        DB::table('users')->insert([
            'name' => 'User Satu',
            'email' => 'user1@example.com',
            'no_hp' => '081111111111',
            'password' => Hash::make('password123'),
            'role' => 0, // user
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'name' => 'User Dua',
            'email' => 'user2@example.com',
            'no_hp' => '082222222222',
            'password' => Hash::make('password123'),
            'role' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'no_hp' => '089999999999',
            'password' => Hash::make('qwerty'),
            'role' => 2, // super admin
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
