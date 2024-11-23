<?php

namespace Modules\Venue\Tests\Unit;

use App\Repositories\BaseRepository;
use App\Services\Interfaces\CrudServiceInterface;
use Illuminate\Database\Eloquent\Model;
use Mockery;
use Modules\Venue\Entities\Venue;
use Modules\Venue\Repositories\VenueRepository;
use Modules\Venue\Services\VenueCrudService;
use Tests\TestCase;

class VenueServiceTest extends TestCase
{
    /**
     * @var CrudServiceInterface|VenueCrudService
     */
    private CrudServiceInterface $service;

    /**
     * @var BaseRepository|(Mockery\MockInterface&object&Mockery\LegacyMockInterface)|VenueRepository|(VenueRepository&Mockery\MockInterface&object&Mockery\LegacyMockInterface)
     */
    private BaseRepository $repository;


    public function setUp(): void
    {
        parent::setUp();
        $this->repository = Mockery::mock(VenueRepository::class);
        $this->service = new VenueCrudService($this->repository);
    }

    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    private function makeModel(array $data): Model
    {
        return  (new Venue())->fill($data);
    }

    public function testCanCreateVenue(): void
    {
        $data = [
            'name' => 'Test venue',
            'capacity' => 50,
        ];

        $venueEntity = $this->makeModel($data);
        $this->repository->shouldReceive('create')->once()->andReturn($venueEntity);
        $venue = $this->service->create($data);

        $this->assertInstanceOf(Venue::class, $venue);
        $this->assertEquals($data['name'], $venue->name);
        $this->assertEquals($data['capacity'], $venue->capacity);
    }

    public function testCanFindVenueById(): void
    {
        $venueEntity = $this->makeModel([
            'name' => 'Test venue',
            'capacity' => 50,
            'id' => 1
        ]);

        $this->repository->shouldReceive('find')->once()->andReturn($venueEntity);
        $venue = $this->service->find(1);

        $this->assertInstanceOf(Venue::class, $venue);
        $this->assertEquals($venueEntity->name, $venue->name);
        $this->assertEquals($venueEntity->capacity, $venue->capacity);
    }
}
