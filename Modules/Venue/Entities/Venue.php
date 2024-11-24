<?php

namespace Modules\Venue\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Event\Entities\Event;

class Venue extends Model
{
    /**
     * @var string
     */
    protected $table = 'venues';

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'capacity',
        'created_at',
        'updated_at',
    ];

    /**
     * @return HasMany
     */
    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

}
