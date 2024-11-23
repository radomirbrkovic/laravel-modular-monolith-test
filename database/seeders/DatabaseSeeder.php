<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Venue\Database\Seeders\VenueSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(VenueSeeder::class);
        $this->call(EventSeeder::class);
    }
}
