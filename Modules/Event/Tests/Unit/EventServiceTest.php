<?php

namespace Modules\Event\Tests\Unit;

use App\Repositories\BaseRepository;
use App\Services\Interfaces\CrudServiceInterface;
use Illuminate\Database\Eloquent\Model;
use Mockery;
use Modules\Event\Entities\Event;
use Modules\Event\Repositories\EventRepository;
use Modules\Event\Services\EventCrudService;
use Tests\TestCase;

class EventServiceTest extends TestCase
{
    /**
     * @var CrudServiceInterface|EventCrudService
     */
    private CrudServiceInterface $service;

    /**
     * @var BaseRepository|(Mockery\MockInterface&object&Mockery\LegacyMockInterface)|EventRepository|(EventRepository&Mockery\MockInterface&object&Mockery\LegacyMockInterface)
     */
    private BaseRepository $repository;


    public function setUp(): void
    {
        parent::setUp();
        $this->repository = Mockery::mock(EventRepository::class);
        $this->service = new EventCrudService($this->repository);
    }

    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    private function makeModel(array $data): Model
    {
        return  (new Event())->fill($data);
    }


    public function testCanCreateEvent(): void
    {
        $data = [
            'venue_id' => 1,
            'name' => 'Test event',
            'ticket_sales_end_date' => now(),
            'available_tickets' => 100,
        ];

        $eventEntity = $this->makeModel($data);
        $this->repository->shouldReceive('getVenueCapacity')->once()->andReturn($data['available_tickets']);
        $this->repository->shouldReceive('create')->once()->andReturn($eventEntity);
        $event = $this->service->create($data);

        $this->assertInstanceOf(Event::class, $event);
        $this->assertEquals($data['venue_id'], $event->venue_id);
        $this->assertEquals($data['name'], $event->name);
        $this->assertEquals($data['ticket_sales_end_date'], $event->ticket_sales_end_date);
        $this->assertEquals($data['available_tickets'], $event->available_tickets);
    }

    public function testCanFindEventById(): void
    {
        $data = [
            'id' => 1,
            'venue_id' => 1,
            'name' => 'Concert',
            'available_tickets' => 150,
        ];
        $eventEntity = $this->makeModel($data);
        $this->repository->shouldReceive('getModel')->once()->andReturn($eventEntity);
        $event = $this->service->find(1);

        $this->assertInstanceOf(Event::class, $event);
        $this->assertEquals($eventEntity->venue_id, $event->venue_id);
        $this->assertEquals($eventEntity->name, $event->name);
        $this->assertEquals($eventEntity->available_tickets, $event->available_tickets);
    }

    public function testCanUpdateEvent(): void
    {
        $data = [
            'id' => 1,
            'venue_id' => 1,
            'name' => 'Test event',
            'ticket_sales_end_date' => now(),
            'available_tickets' => 100,
        ];
        $eventEntity = $this->makeModel($data);

        $data['name'] = 'Test event - updated';
        $updatedEvent = $this->makeModel($data);
        $this->repository->shouldReceive('getModel')->once()->andReturn($eventEntity);
        $this->repository->shouldReceive('update')->once()->andReturn($updatedEvent);
        $event = $this->service->update($data['id'], $data);

        $this->assertInstanceOf(Event::class, $event);
        $this->assertEquals($updatedEvent->venue_id, $event->venue_id);
        $this->assertEquals($updatedEvent->name, $event->name);
        $this->assertEquals($updatedEvent->ticket_sales_end_date, $event->ticket_sales_end_date);
        $this->assertEquals($updatedEvent->available_tickets, $event->available_tickets);
    }

    public function testCanDeleteVenue(): void
    {
        $data = [
            'id' => 1,
            'venue_id' => 1,
            'name' => 'Test event',
            'ticket_sales_end_date' => now(),
            'available_tickets' => 100,
        ];
        $eventEntity = $this->makeModel($data);

        $this->repository->shouldReceive('getModel')->once()->andReturn($eventEntity);
        $this->repository->shouldReceive('delete')->once()->andReturn(true);
        $this->assertTrue($this->service->delete(1));

    }
}
