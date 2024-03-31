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
            'name' => 'Admin user',
            'email' => 'admin@test.nl',
            'is_admin' => true
        ]);

        User::factory()->create([
            'name' => 'Test user',
            'email' => 'test@test.nl'
        ]);
        User::factory()->create([
            'name' => 'Test user2',
            'email' => 'test2@test.nl'
        ]);

        $id = 1;
        while ($id <= 3) {
            Listing::factory(10)->create([
                'user_id' => $id
            ]);
            $id ++;
        }
    }
}
