<?php

namespace Modules\Event\Repositories;

use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\Event\Entities\Event;
use Modules\Venue\Entities\Venue;

class EventRepository extends BaseRepository
{
    public function __construct(Event $model)
    {
        parent::__construct($model);
    }

    /**
     * @param int $id
     * @return Model|null
     */
    public function find(int $id): ?Model
    {
        return $this->model->with('venue')->find($id);
    }

    /**
     * @return Collection
     */
    public function list(): Collection
    {
        return $this->model->with('venue')->get();
    }

    /**
     * @param int $venueId
     * @return int
     */
    public function getVenueCapacity(int $venueId): int
    {
        $venue = Venue::find($venueId);
        return $venue->capacity;
    }
}
