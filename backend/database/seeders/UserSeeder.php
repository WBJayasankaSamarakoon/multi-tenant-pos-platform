<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Seed only the Platform Administrator user.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@demo.lk'],
            [
                'name' => 'Platform Administrator',
                'role' => 'admin',
                'password' => Hash::make('demo1234'),
                'email_verified_at' => now(),
            ]
        );
    }
}
