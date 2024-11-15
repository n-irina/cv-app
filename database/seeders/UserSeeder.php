<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'user1',
            'email' => 'user1@demo.com',
            'password' => Hash::make('@Demo2024!'),
            'is_admin' => false,
        ]);

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@demo.com',
            'password' => Hash::make('@Demo2024!'),
            'is_admin' => true,
        ]);
    }
}
