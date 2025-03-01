<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Wallet;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'role' => 'admin',
            'name' => 'KG500005',
            'email_verified_at' => now(),
            'password' => Hash::make('king@123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Wallet::create([
            'user_id' => 1, // Dynamically fetch user ID
            'balance' => 0, // Store numbers as integers, not strings
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
