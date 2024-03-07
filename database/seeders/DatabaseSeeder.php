<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         $password = env('DEFAULT_USER_PASSWORD');

         User::create([
             'username' => 'scgvn',
             'password' => Hash::make($password),
         ]);
    }
}
