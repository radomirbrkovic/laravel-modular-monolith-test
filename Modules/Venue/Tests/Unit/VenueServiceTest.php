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

    public function testCanUpdateVenue(): void
    {
        $venueEntity = $this->makeModel([
            'name' => 'Test venue',
            'capacity' => 50,
            'id' => 1
        ]);

        $data = [
            'name' => 'Test venue updated',
            'capacity' => 100,
            'id' => 1
        ];
        $updatedVenue = $this->makeModel($data);
        $this->repository->shouldReceive('find')->once()->andReturn($venueEntity);
        $this->repository->shouldReceive('update')->once()->andReturn($updatedVenue);
        $venue = $this->service->update($data['id'], $data);

        $this->assertInstanceOf(Venue::class, $venue);
        $this->assertEquals($venueEntity->id, $venue->id);
        $this->assertEquals($updatedVenue->name, $venue->name);
        $this->assertEquals($updatedVenue->capacity, $venue->capacity);
    }

    public function testCanDeleteVenue(): void
    {
        $venueEntity = $this->makeModel([
            'name' => 'Test venue',
            'capacity' => 50,
            'id' => 1
        ]);

        $this->repository->shouldReceive('find')->once()->andReturn($venueEntity);
        $this->repository->shouldReceive('delete')->once()->andReturn(true);
        $this->assertTrue($this->service->delete(1));

    }
}
