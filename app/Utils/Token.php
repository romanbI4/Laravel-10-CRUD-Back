<?php

namespace App\Utils;

use App\Models\User;

class Token
{
    /**
     * @param User $user
     * @return string
     */
    public static function create(User $user): string
    {
        return $user->createToken('token')->plainTextToken;
    }
}
