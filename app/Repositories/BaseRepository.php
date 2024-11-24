<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

abstract class BaseRepository
{
    public function __construct(protected Model $model)
    {

    }

    /**
     * @return Model
     */
    public function getModel(): Model
    {
        return $this->model;
    }

    /**
     * @return Collection
     */
    public function list(): Collection
    {
        return $this->model->all();
    }
    /**
     * @param int $id
     * @return Model|null
     */
    public function find(int $id): ?Model
    {
        return $this->model->find($id);
    }


    /**
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model
    {
        $entity = DB::transaction(function () use ($data) {
            return $this->model->create($data);
        });

        return $entity;
    }

    /**
     * @param Model $entity
     * @param array $data
     * @return Model
     */
    public function update(Model $entity, array $data): Model
    {
        return DB::transaction(function () use ($entity, $data) {
            $entity->update($data);

            return $entity;
        });
    }

    /**
     * @param Model $entity
     * @return bool
     */
    public function delete(Model $entity): bool
    {
        return DB::transaction(function () use ($entity) {
            return $entity->delete();
        });
    }
}
