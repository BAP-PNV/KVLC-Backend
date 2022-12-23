<?php

namespace App\Repositories\Implementations;

use App\Repositories\Interfaces\IRepository;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

abstract class BaseRepository implements IRepository
{
    protected string $model;
    protected Builder $query;

    public abstract function getModel();

    /**
     * @throws BindingResolutionException
     */
    public function setModel()
    {
        $this->model = app()->make($this->getModel());
    }

    public function getQuery(): Builder|\Illuminate\Database\Query\Builder
    {
        return $this->query->getQuery();
    }

    public function clearQuery(): \Illuminate\Database\Query\Builder
    {
        $this->query = $this->model->newQuery();
        return $this->query->getQuery();
    }

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function findById($id): mixed
    {
        return $this->model->find($id);
    }

    public function create($attributes = []): mixed
    {
        return $this->model->create($attributes);
    }

    public function update($id, array $attributes = []): mixed
    {
        return $this->model->update($id, $attributes);
    }

    public function updateWhere(array $attributes, array $params): mixed
    {
        return $this->model->where($attributes)->update($params);
    }

    public function findBy(array $filter, bool $toArray = true): Collection|array|null
    {
        $builder = $this->model->newQuery();
        foreach ($filter as $key => $val) {
            $builder->where($key, $val);
        }
        $find = $builder->get();

        if (!$toArray) {
            return $find;
        }
        return $find ? $find->toArray() : null;
    }

    public function findOneBy(array $filter): mixed
    {
        $builder = $this->model->newQuery();
        foreach ($filter as $key => $val) {
            $builder->where($key, $val);
        }
        $data = $builder->first();

        return $data;
    }
    public function paginate($page): LengthAwarePaginator
    {
        return $this->query->paginate($page);
    }
    public function with($relationship): mixed
    {
        return $this->model->$relationship;
    }
}

