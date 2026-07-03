<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Seed demo users used by the public login flow.
     */
    public function run(): void
    {
        $users = [
            ['name' => 'Demo Owner', 'email' => 'owner@demo.lk'],
            ['name' => 'Demo Cashier', 'email' => 'cashier@demo.lk'],
            ['name' => 'Demo Manager', 'email' => 'manager@demo.lk'],
            ['name' => 'Demo Admin', 'email' => 'admin@demo.lk'],
            ['name' => 'Test User', 'email' => 'test@example.com'],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'password' => 'demo1234',
                    'email_verified_at' => now(),
                ]
            );
        }
    }
}
