<?php

namespace Modules\Event\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'event_name' => $this->name,
            'venue_name' => $this->venue->name,
            'available_tickets' => (int) $this->available_tickets,
            'ticket_sales_end_date' => $this->ticket_sales_end_date,
        ];
    }
}
