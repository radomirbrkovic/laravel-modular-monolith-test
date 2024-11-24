<?php

namespace Modules\Event\Repositories;

use App\Repositories\BaseRepository;
use Modules\Event\Entities\Event;
use Modules\Venue\Entities\Venue;

class EventRepository extends BaseRepository
{
    public function __construct(Event $model)
    {
        parent::__construct($model);
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
