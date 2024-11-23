<?php

namespace Modules\Venue\Repositories;

use App\Repositories\BaseRepository;
use Modules\Venue\Entities\Venue;

class VenueRepository extends BaseRepository
{
    public function __construct(Venue $model)
    {
        parent::__construct($model);
    }
}
