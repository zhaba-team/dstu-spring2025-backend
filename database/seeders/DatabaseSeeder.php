<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create(
            [
                'name'     => env('USER_NAME') ?? 'admin',
                'email'    => env('USER_EMAIL') ??'admin@admin.com',
                'role'    =>  UserRole::Developer,
                'password' => Hash::make(env('USER_PASSWORD') ?? 'password'),
            ]
        );
    }
}
