<?php

namespace Database\Seeders;

use App\Models\Portfolio;
use App\Models\Strategy;
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
        $user = User::factory()->create([
            'name' => 'Carl Mabugay',
            'email' => 'admin@carlmabugay.dev',
        ]);

        Portfolio::factory()
            ->count(255)
            ->for($user)
            ->create();

        Strategy::factory()
            ->count(255)
            ->for($user)
            ->create();

    }
}
