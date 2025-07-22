<?php

namespace App\Policies;

use App\Models\User;

class ManageUsersPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function manageUsers(User $user): bool
    {
        return $user->hasRole('admin');
    }
}
