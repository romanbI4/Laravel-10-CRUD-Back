<?php

namespace App\Repositories;

use App\Interfaces\UsersRepositoryInterface;
use App\Models\Users;

class UsersRepository implements UsersRepositoryInterface
{
    public function create(array $details)
    {
        return Users::create($details);
    }

    public function getOneByParams($column, $params)
    {
        return Users::where($column, $params)->first();
    }

    public function updateOneByParams($id, $params)
    {
        return Users::whereId($id)->update($params);
    }
}
