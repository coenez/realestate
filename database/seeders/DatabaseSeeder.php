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
        Listing::factory(20)->create([
            'user_id' => 1
        ]);
    }
}
