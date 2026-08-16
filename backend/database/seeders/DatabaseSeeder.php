<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database with only the Administrator account.
     */
    public function run(): void
    {
        if (! Schema::hasTable('users')) {
            Artisan::call('migrate', [
                '--force' => true,
            ]);
        }

        User::updateOrCreate(
            ['email' => 'admin@demo.lk'],
            [
                'name' => 'Platform Administrator',
                'role' => 'admin',
                'password' => 'demo1234',
                'email_verified_at' => now(),
            ]
        );
    }
}
