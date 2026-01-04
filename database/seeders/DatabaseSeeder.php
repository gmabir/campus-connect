<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@campus.com',
            'role' => 'admin',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Prof. Teacher',
            'email' => 'teacher@campus.com',
            'role' => 'teacher',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Student',
            'email' => 'student@campus.com',
            'role' => 'student',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Guest Visitor',
            'email' => 'visitor@campus.com',
            'role' => 'visitor',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Burger King Manager',
            'email' => 'cafe@campus.com',
            'role' => 'cafe_owner',
            'password' => Hash::make('password'),
        ]);
    }
}
