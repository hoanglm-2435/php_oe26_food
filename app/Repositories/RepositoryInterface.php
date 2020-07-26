<?php

namespace App\Repositories;

interface RepositoryInterface
{
    public function getAll();

    public function showList($field, $type, $page);

    public function create($data = []);

    public function getById($id);

    public function update($id, $data = []);

    public function delete($id);

    public function getWhereEqual($column, $condition);

    public function insert($data = []);
}
