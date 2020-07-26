<?php

namespace App\Repositories;

use App\Repositories\RepositoryInterface;

abstract class BaseRepository implements RepositoryInterface
{
    protected $model;

    public function __construct()
    {
        $this->setModel();
    }

    abstract function getModel();

    public function setModel()
    {
        $this->model = app()->make($this->getModel());
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function showList($field, $type, $page)
    {
        return $this->model->orderBy($field, $type)
            ->paginate($page);
    }

    public function create($data = [])
    {
        return $this->model->create($data);
    }

    public function getById($id)
    {
        return $this->model->findOrFail($id);
    }

    public function update($id, $data = [])
    {
        $result = $this->getById($id);

        if ($result) {
            $result->update($data);

            return $result;
        }

        return false;
    }

    public function delete($id)
    {
        $result = $this->getById($id);

        if ($result) {
            $result->delete();

            return true;
        }

        return false;
    }

    public function getWhereEqual($column, $condition)
    {
        return $this->model->where($column, $condition)->get();
    }

    public function insert($data = [])
    {
        return $this->model->insert($data);
    }
}
