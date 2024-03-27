<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing users
        DB::table('users')->delete();

        // Create a default user
        User::create([
            'name' => 'Melvin van Vliet',
            'email' => 'melvinvanvliet@hotmail.com',
            'password' => Hash::make('admin'),
            'is_blocked'=> 0,
            'is_admin' => 1,
        ]);
    }
}
