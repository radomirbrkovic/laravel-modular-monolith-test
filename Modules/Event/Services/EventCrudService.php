<?php

namespace Modules\Event\Services;

use App\Services\Interfaces\CrudServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\Event\Repositories\EventRepository;

class EventCrudService implements CrudServiceInterface
{

    public function __construct(readonly EventRepository $repository)
    {

    }

    public function list(): Collection
    {
        return $this->repository->list();
    }

    public function create(array $data): Model
    {
        $data['available_tickets'] = $this->repository->getVenueCapacity($data['venue_id']);
        return $this->repository->create($data);
    }

    public function find(int $id): Model
    {
        return $this->repository->find($id);
    }

    public function update(int $id, array $data): Model
    {
        return $this->repository->update($this->find($id), $data);
    }

    public function delete(int $id): bool
    {
        return $this->repository->delete($this->find($id));
    }
}
