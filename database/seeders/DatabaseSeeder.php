<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'name' => 'Admin User',
            'email' =>'admin@campus.com',
            'role' => 'admin',
            'password' => bcrypt('password'),
        ]);
        \App\Models\User::factory()->create([
            'name' => 'Prof. Teacher',
            'email' =>'teacher@campus.com',
            'role' => 'teacher',
            'password' => bcrypt('password'),       
        ]);
        \App\Models\User::factory()->create([
            'name' => 'student',
            'email' =>'student@campus.com',
            'role' => 'student',
            'password' => bcrypt('password'),
        ]);   
        \App\Models\User::factory()->create([
            'name' => 'Guest Visitor',
            'email' =>'visitor@campus.com',
            'role' => 'visitor',
            'password' => bcrypt('password'),
        ]);  
        // Cafe Owner User
        \App\Models\User::factory()->create([
        'name' => 'Burger King Manager',
        'email' => 'cafe@campus.com',
        'role' => 'cafe_owner',
        'password' => bcrypt('password'),
        ]);   
    
        
    }
}
