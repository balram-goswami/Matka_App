<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'role' => 'admin',
                'name' => 'Admin',
                'email' => 'admin@matka.com',
                'phone' => '9000000000',
                'email_verified_at' => now(),
                'password' => Hash::make('matka'),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        User::insert($users);
    }
}
