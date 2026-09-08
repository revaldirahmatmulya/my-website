<?php

namespace Database\Seeders;

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
        // Admin user for project management
        User::updateOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@example.com')],
            [
                'name' => env('PORTFOLIO_NAME', 'Aldi'),
                'password' => Hash::make(env('ADMIN_PASSWORD', 'password')),
            ]
        );

        $this->call([
            ProjectSeeder::class,
        ]);
    }
}
