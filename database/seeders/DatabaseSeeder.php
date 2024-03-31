<?php

namespace Database\Seeders;

use App\Models\Listing;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test user',
            'email' => 'test@example.com'

        ]);
        User::factory()->create([
            'name' => 'Test user2',
            'email' => 'test2@example.com'

        ]);
        Listing::factory(10)->create([
            'user_id' => 1
        ]);
        Listing::factory(10)->create([
            'user_id' => 2
        ]);
    }
}
