<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('admin'),
                'role' => 'admin',
            ]
        );

        User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'User',
                'password' => bcrypt('user'),
                'role' => 'user',
            ]
        );

        User::firstOrCreate(
            ['email' => 'user2@example.com'],
            [
                'name' => 'User',
                'password' => bcrypt('user'),
                'role' => 'user',
            ]
        );
    }
}
