<?php

namespace Modules\Event\Tests\Feature;

use Illuminate\Testing\Fluent\AssertableJson;
use Modules\Event\Database\Seeders\EventSeeder;
use Modules\Event\Entities\Event;
use Modules\Event\Http\Controllers\Api\EventController;
use Modules\Venue\Database\Seeders\VenueSeeder;
use Modules\Venue\Entities\Venue;
use Tests\Feature\BaseTestCase;

class EventCrudTest extends BaseTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->seed(VenueSeeder::class);
        $this->seed(EventSeeder::class);
    }

    public function testCanListEvents(): void
    {
        $events = Event::with('venue')->get();
        $eventsData = [];

        foreach ($events as $key => $event) {
            $eventsData["data.{$key}.id"] = $event->id;
            $eventsData["data.{$key}.event_name"] = $event->name;
            $eventsData["data.{$key}.venue_name"] = $event->venue->name;
            $eventsData["data.{$key}.available_tickets"] = $event->available_tickets;
            $eventsData["data.{$key}.ticket_sales_end_date"] = $event->ticket_sales_end_date;
        }

        $this->getJson(action([EventController::class, 'index']))
            ->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json->has('data')->whereAllType([
                'data.0.id' => 'integer',
                'data.0.event_name' => 'string',
                'data.0.venue_name' => 'string',
                'data.0.available_tickets' => 'integer',
                'data.0.ticket_sales_end_date' => 'string',
            ])->etc())
            ->assertJson(fn(AssertableJson $json) => $json->has('data')->whereAll($eventsData)->etc());
    }

    public function testCanCreateEventInvalidData(): void
    {
        $payload = [];
        $this->postJson(action([EventController::class, 'store']), $payload)
            ->assertStatus(422)->assertJsonValidationErrors(
                [
                    'name',
                    'venue_id',
                    'ticket_sales_end_date',
                ]);

        $payload = [
            'name' => 'Test Event',
            'venue_id' => 1000,
            'ticket_sales_end_date' => '2020-12-31',
        ];
        $this->postJson(action([EventController::class, 'store']), $payload)
            ->assertStatus(422)->assertJsonValidationErrors(
                [
                    'venue_id',
                    'ticket_sales_end_date',
                ]);
    }

    public function testCanCreateEventSuccessfully(): void
    {
        $venue = Venue::find(1);
        $payload = [
          'name' => 'Test Event',
          'venue_id' => $venue->id,
          'ticket_sales_end_date' => now()->addDays(10)->format('Y-m-d H:i:s'),
        ];

        $this->postJson(action([EventController::class, 'store']), $payload)
            ->assertStatus(201)
            ->assertJson(fn(AssertableJson $json) => $json->has('data')->whereAll([
                'data.event_name' => $payload['name'],
                'data.venue_name' => $venue->name,
                'data.available_tickets' => $venue->capacity,
                'data.ticket_sales_end_date' => $payload['ticket_sales_end_date'],
            ])->etc());
    }

    public function testCanShowEvent(): void
    {
        $event = Event::with('venue')->find(1);

        $this->getJson(action([EventController::class, 'show'], ['event' => $event->id]))
            ->assertOk()->assertJson(fn(AssertableJson $json) => $json->has('data')->whereAll([
                'data.event_name' => $event->name,
                'data.venue_name' => $event->venue->name,
                'data.available_tickets' => $event->available_tickets,
                'data.ticket_sales_end_date' => $event->ticket_sales_end_date,
            ])->etc());
    }

    public function testCanUpdateEvent(): void
    {
        $event = Event::with('venue')->find(1);
        $payload = [
            'name' => 'Test Event',
        ];

        $this->putJson(action([EventController::class, 'update'], ['event' => $event->id]), $payload)
            ->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json->has('data')->whereAll([
                'data.event_name' => $payload['name'],
                'data.venue_name' => $event->venue->name,
                'data.available_tickets' => $event->available_tickets,
                'data.ticket_sales_end_date' => $event->ticket_sales_end_date,
            ])->etc());
    }
}
