<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run($count = 1, $roles = ['VIP'])
    {
        $users = [];
        
        for ($i = 0; $i < $count; $i++) {
            $role = $roles[array_rand($roles)];
            $users[] = [
                'name' => "User " . ($i + 1),
                'email' => "user" . ($i + 1) . "@example.com",
                'password' => Hash::make('password'),
                'role' => $role,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        User::insert($users);
    }
}
