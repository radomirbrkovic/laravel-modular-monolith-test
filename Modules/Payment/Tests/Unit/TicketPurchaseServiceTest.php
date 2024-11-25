<?php

namespace Modules\Payment\Tests\Unit;

use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Mockery;
use Modules\Event\Entities\Event;
use Modules\Payment\Entities\TicketPurchase;
use Modules\Payment\Repositories\TickerPurchaseRepository;
use Modules\Payment\Services\TicketPurchaseService;
use Tests\TestCase;

class TicketPurchaseServiceTest extends TestCase
{
    /**
     * @var TicketPurchaseService
     */
    private TicketPurchaseService $service;

    /**
     * @var BaseRepository|(Mockery\MockInterface&object&Mockery\LegacyMockInterface)|TickerPurchaseRepository|(TickerPurchaseRepository&Mockery\MockInterface&object&Mockery\LegacyMockInterface)
     */
    private BaseRepository $repository;


    public function setUp(): void
    {
        parent::setUp();
        $this->repository = Mockery::mock(TickerPurchaseRepository::class);
        $this->service = new TicketPurchaseService($this->repository);
    }

    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    private function makeModel(array $data): Model
    {
        return  (new TicketPurchase())->fill($data);
    }


    public function testCanCreateTicketPurchase(): void
    {
        $data = [
            'event_id' => 1,
            'email' => 'test@example.com'
        ];
        $event = new Event([
            'id' => 1,
            'venue_id' => 1,
            'name' => 'Test Event',
            'ticket_sales_end_date' => now()->addDays(10),
            'available_tickets' => 100,
        ]);

        $entity = $this->makeModel($data);
        $this->repository->shouldReceive('getEventById')->once()->andReturn($event);
        $this->repository->shouldReceive('create')->once()->andReturn($entity);
        $result = $this->service->create($data);

        $this->assertInstanceOf(TicketPurchase::class, $result);
        $this->assertEquals($data['event_id'], $result->event_id);
        $this->assertEquals($data['email'], $result->email);
    }

}
