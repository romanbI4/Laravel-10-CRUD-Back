<?php

namespace App\Utils;

use App\Models\Company;
use App\Models\User;

class Permission
{
    /**
     * @param string $ability
     * @param User $user
     * @param Company $company
     * @return bool
     */
    public static function available(string $ability, User $user, Company $company): bool
    {
        if ($user->can($ability, $company)) {
            return true;
        }

        return false;
    }
}
