<?php

namespace Modules\Venue\Services;

use App\Services\Interfaces\CrudServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\Venue\Repositories\VenueRepository;

class VenueCrudService implements CrudServiceInterface
{

    public function __construct(readonly VenueRepository $venueRepository)
    {

    }

    public function list(): Collection
    {
        return $this->venueRepository->list();
    }

    public function create(array $data): Model
    {
        return $this->venueRepository->create($data);
    }

    public function find(int $id): Model
    {
        return $this->venueRepository->find($id);
    }

    public function update(int $id, array $data): Model
    {
        return $this->venueRepository->update($this->find($id), $data);
    }

    public function delete(int $id): bool
    {
        return $this->venueRepository->delete($this->find($id));
    }
}
