<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\UserRole;
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
        User::factory()->create(
            [
                'name'     => 'admin',
                'email'    => 'admin@gmail.com',
                'role'    =>  UserRole::Developer,
                'password' => Hash::make('password'),
            ]
        );

        $this->call([
            MemberSeeder::class,
            RaceSeeder::class,
        ]);
    }
}
