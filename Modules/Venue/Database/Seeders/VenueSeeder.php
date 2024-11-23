<?php

namespace Modules\Venue\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class VenueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('venues')->truncate();
        DB::table('venues')->insert([
            [
                'name' => 'Main Venue',
                'capacity' => 150,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Small Venue',
                'capacity' => 50,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
        Schema::enableForeignKeyConstraints();
    }
}
