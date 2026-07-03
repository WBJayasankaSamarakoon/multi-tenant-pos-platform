<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = [
            ['name' => 'Owner Demo', 'email' => 'owner@demo.lk', 'role' => 'owner'],
            ['name' => 'Cashier Demo', 'email' => 'cashier@demo.lk', 'role' => 'cashier'],
            ['name' => 'Manager Demo', 'email' => 'manager@demo.lk', 'role' => 'manager'],
            ['name' => 'Platform Admin Demo', 'email' => 'admin@demo.lk', 'role' => 'admin'],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'role' => $user['role'],
                    'password' => 'demo1234',
                ]
            );
        }
    }
}
