<?php

namespace Modules\Payment\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Event\Entities\Event;

class TicketPurchase extends Model
{
    protected $table = 'ticket_purchases';

    protected $fillable = [
      'event_id',
      'email',
      'transaction_id',
      'created_at',
      'updated_at',
    ];

    /**
     * @return BelongsTo
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
