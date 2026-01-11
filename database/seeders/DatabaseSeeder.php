<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call other seeders
        $this->call([
            UserSeeder::class,
            VolunteerSeeder::class,
            TaskSeeder::class,
            WorkplaceSeeder::class,
        ]);
    }
}
