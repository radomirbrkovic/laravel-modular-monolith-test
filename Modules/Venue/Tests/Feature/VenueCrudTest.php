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
            ->assertJson(fn(AssertableJson $json) => $json->has('data')->whereAllType([
                'data.0.id' => 'integer',
                'data.0.name' => 'string',
                'data.0.capacity' => 'integer',
            ])->etc())
            ->assertJson(fn(AssertableJson $json) => $json->has('data')->whereAll($venuesData)->etc());
    }


    public function testCanCreateVenueInvalidData(): void
    {
        $payload = [];

        $this->postJson(action([VenueController::class, 'store']), $payload)
            ->assertStatus(422)->assertJsonValidationErrors(['name', 'capacity']);

        $payload = ['name' => 'Small Venue', 'capacity' => 100];

        $this->postJson(action([VenueController::class, 'store']), $payload)
            ->assertStatus(422)->assertJsonValidationErrors(['name']);

    }

    public function testCanCreateVenueSuccessfully(): void
    {
        $payload = [
            'name' => 'Test Venue',
            'capacity' => 100,
        ];

        $this->postJson(action([VenueController::class, 'store']), $payload)
            ->assertStatus(201)
            ->assertJson(fn(AssertableJson $json) => $json->has('data')->whereAll([
                'data.name' => $payload['name'],
                'data.capacity' => $payload['capacity'],
            ])->etc());
    }

    public function testCanShowVenue(): void
    {
        $venue = Venue::find(1);
        $this->getJson(action([VenueController::class, 'show'], ['venue' => 1]))
            ->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) => $json->has('data')->whereAll([
                'data.name' => $venue->name,
                'data.capacity' => $venue->capacity,
            ])->etc());
    }

    public function testCanUpdateVenue(): void
    {
        $payload = [
            'name' => 'Main Venue',
            'capacity' => 150,
        ];

        $this->putJson(action([VenueController::class, 'update'], ['venue' => 1]), $payload)
            ->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) => $json->has('data')->whereAll([
                'data.name' => $payload['name'],
                'data.capacity' => $payload['capacity'],
            ])->etc());
    }

    public function testCanDelete(): void
    {

        $this->deleteJson(action([VenueController::class, 'destroy'], ['venue' => 1]))
            ->assertStatus(204);

        $venue = Venue::find(1);
        $this->assertNull($venue);
    }
}
