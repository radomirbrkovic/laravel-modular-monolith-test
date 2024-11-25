<?php

namespace Modules\Payment\Tests\Feature;

use Illuminate\Support\Str;
use Illuminate\Testing\Fluent\AssertableJson;
use Modules\Event\Database\Seeders\EventSeeder;
use Modules\Event\Entities\Event;
use Modules\Payment\Entities\TicketPurchase;
use Modules\Venue\Database\Seeders\VenueSeeder;
use Tests\Feature\BaseTestCase;

class TicketPurchasesTests extends BaseTestCase
{

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(VenueSeeder::class);
        $this->seed(EventSeeder::class);
        TicketPurchase::truncate();
    }


    public function testTicketPurchaseInvalidBodyRequest(): void
    {
        $this->postJson(route('events.purchase.store',  ['event_id' => 1]), [])
            ->assertStatus(422)->assertJsonValidationErrors(
                [
                    'email',
                ]);
    }

    public function testTicketPurchaseEventNotFound(): void
    {
        $this->postJson(route('events.purchase.store',  ['event_id' => 45445]), ['email' => 'test@test.com'])
            ->assertStatus(400)->assertJson([
                'message' => "Event not found",
            ]);
    }

    public function testTicketPurchaseEventExpired(): void
    {
        $this->postJson(route('events.purchase.store',  ['event_id' => 2]), ['email' => 'test@test.com'])
            ->assertStatus(400)->assertJson([
                'message' => "The event is closed.",
            ]);
    }

    public function testTicketPurchaseNotAvailableSeats(): void
    {
        Event::where('id', 1)->update(['available_tickets' => 0]);

        $this->postJson(route('events.purchase.store',  ['event_id' => 1]), ['email' => 'test@test.com'])
            ->assertStatus(400)->assertJson([
                'message' => "No available seats for this event.",
            ]);
    }

    public function testTicketPurchaseEmailAlreadyUsed(): void
    {
        TicketPurchase::create([
            'event_id' => 1,
            'email' => 'test@test.com',
            'transaction_id' => Str::random(8)
        ]);

        $this->postJson(route('events.purchase.store',  ['event_id' => 1]), ['email' => 'test@test.com'])
            ->assertStatus(400)->assertJson([
                'message' => "Email already used for this event.",
            ]);
    }

    public function testTicketPurchaseSuccessfully(): void
    {
        $this->postJson(route('events.purchase.store',  ['event_id' => 1]), ['email' => 'test@test.com'])
            ->assertStatus(200)  ->assertJson(fn(AssertableJson $json) => $json->has('data')->whereAllType([
                'data.transaction_id' => 'string',
            ])->etc());
    }


}
