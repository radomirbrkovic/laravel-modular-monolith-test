<?php

namespace Modules\Payment\Services;

use App\Services\Interfaces\CrudServiceInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Payment\Exceptions\EmailAlreadyUsedException;
use Modules\Payment\Exceptions\EventCloseException;
use Modules\Payment\Exceptions\NotAvelableSeatsException;
use Modules\Payment\Repositories\TickerPurchaseRepository;

class TicketPurchaseService
{

    public function __construct(readonly TickerPurchaseRepository $repository)
    {

    }

    public function list(): Collection
    {
        return $this->repository->list();
    }

    /**
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model
    {
        $event = $this->repository->getEventById($data['event_id']);

        if (Carbon::parse($event->ticket_sales_end_date) < now()) {
            throw new EventCloseException();
        }

        if($event->available_tickets < 1) {
            throw new NotAvelableSeatsException();
        }

        if($event->ticketPurchases->contains('email', $data['email'])) {
            throw new EmailAlreadyUsedException();
        }

        $data['transaction_id'] = Str::random(8);
        return $this->repository->create($data);
    }
}
