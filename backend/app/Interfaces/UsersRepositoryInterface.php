<?php

namespace App\Interfaces;

interface UsersRepositoryInterface
{
    public function create(array $details);

    public function getOneByParams($column, $params);

    public function updateOneByParams($id, $params);
}
