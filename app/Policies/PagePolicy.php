<?php

namespace App\Policies;

use App\Models\Page;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PagePolicy
{
    public function before($user, $ability)
    {
        if ($user->isAdminOrEditor()) {
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Page $page): bool
    {
        return $user->id === $page->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Page $page): bool
    {
        return $user->id === $page->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Page $page): bool
    {
        return $user->id === $page->user_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Page $page): bool
    {
        return $user->id === $page->user_id;
    }
}
