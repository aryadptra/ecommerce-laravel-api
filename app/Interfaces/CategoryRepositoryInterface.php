<?php

namespace App\Interfaces;

interface CategoryRepositoryInterface
{
    public function getAll();
    public function getById($id);
    public function delete($id);
    public function create(array $params);
    public function update($id, array $params);
}
