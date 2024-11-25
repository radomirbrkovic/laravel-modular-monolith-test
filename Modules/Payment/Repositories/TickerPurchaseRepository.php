<?php

namespace Modules\Payment\Repositories;

use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Event\Entities\Event;
use Modules\Payment\Entities\TicketPurchase;

class TickerPurchaseRepository extends BaseRepository
{
    public function __construct(TicketPurchase $model)
    {
        parent::__construct($model);
    }

    /**
     * @param int $id
     * @return Model|null
     */
    public function find(int $id): ?Model
    {
        return $this->model->with('event')->find($id);
    }

    /**
     * @return Collection
     */
    public function list(): Collection
    {
        return $this->model->with('event')->get();
    }

    /**
     * @param int $id
     * @return Model|null
     */
    public function getEventById(int $id): ?Model
    {
        return Event::with('ticketPurchases')->find($id);
    }

    /**
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model
    {
        $event = Event::find($data['event_id']);
        $entity = DB::transaction(function () use ($data, $event) {
            $event->update([
                'available_tickets' => $event->available_tickets - 1,
            ]);
            return $this->model->create($data);
        });

        return $entity;
    }
}
