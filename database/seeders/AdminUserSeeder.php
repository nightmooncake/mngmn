<?php

// database/seeders/AdminUserSeeder.php
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class AdminUserSeeder extends Seeder
{
    public function run()
    {
User ::create([
    'name' => 'jadn',
    'email' => 'ts@gmail.com',
    'password' => Hash::make('12332111'),
    'role_id' => 1, // Ganti dengan ID role yang sesuai
]);

    }
}