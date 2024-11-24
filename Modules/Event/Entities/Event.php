<?php

namespace Modules\Event\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Venue\Entities\Venue;

class Event extends Model
{

    protected $table = 'events';

    protected $fillable = [
        'name',
        'venue_id',
        'available_tickets',
        'ticket_sales_end_date',
        'created_at',
        'updated_at',
    ];

    /**
     * @return BelongsTo
     */
    public function venue(): BelongsTo
    {
        return $this->belongsTo(Venue::class);
    }

}
