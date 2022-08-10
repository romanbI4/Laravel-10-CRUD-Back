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
}
