<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Create admin user
        User::create([
            'name' => 'User',
            'email' => 'user@jobboard.com',
            'password' => Hash::make('password'), // Change this!
            'is_admin' => false
        ]);

        // Create regular users if needed
        User::factory(10)->create();
    }
}