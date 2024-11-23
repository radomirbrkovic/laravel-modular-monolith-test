<?php

namespace Modules\Venue\Tests\Feature;

use Illuminate\Testing\Fluent\AssertableJson;
use Modules\Venue\Database\Seeders\VenueSeeder;
use Modules\Venue\Entities\Venue;
use Modules\Venue\Http\Controllers\Api\VenueController;
use Tests\Feature\BaseTestCase;

class VenueCrudTest extends BaseTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->seed(VenueSeeder::class);
    }

    public function testCanListVenues(): void
    {
        $venues = Venue::get();
        $venuesData = [];

        foreach ($venues as $key => $venue) {
            $venuesData["data.{$key}.id"] = $venue->id;
            $venuesData["data.{$key}.name"] = $venue->name;
            $venuesData["data.{$key}.capacity"] = $venue->capacity;
        }

        $this->getJson(action([VenueController::class, 'index']))
            ->assertOk()
        ->assertJson(fn (AssertableJson $json) => $json->has('data')->whereAllType([
            'data.0.id' => 'integer',
            'data.0.name' => 'string',
            'data.0.capacity' => 'integer',
        ])->etc())
        ->assertJson(fn (AssertableJson $json) => $json->has('data')->whereAll($venuesData)->etc());
    }
}
