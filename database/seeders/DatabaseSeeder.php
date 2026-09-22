<?php

namespace Database\Seeders;

use App\Models\Listing;
use App\Models\User;
use Database\Factories\ListingFactory;
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
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $user->listings()->saveMany(Listing::factory(10)->make());
    }
}
