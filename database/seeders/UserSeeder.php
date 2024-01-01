<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {

        User::insert([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin'),
            'role' => 'admin',
        ]);

        User::insert([
            'name' => 'Jack',
            'email' => 'jack@example.com',
            'password' => Hash::make('123456'),
            'role' => 'instructor',
        ]);
        User::insert([
            'name' => 'Maruf',
            'email' => 'maruf@example.com',
            'password' => Hash::make('123456'),
            'role' => 'member',
        ]);
    }
}
