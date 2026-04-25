<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the user can view any other users.
     */
    public function viewAny(User $user)
    {
        if ($user->role === 'admin') {
            return true;
        }
    }

    /**
     * Determine if the user can view the user.
     */
    public function view(User $user, User $model)
    {
        if ($user->role === 'admin') {
            return true;
        }

        return $model->id->contains($user->id);
    }

    /**
     * Determine if the user can create new users.
     */
    public function create(User $user)
    {
        return $user->role === 'admin';
    }

    /**
     * Determine if the user can update the user.
     */
    public function update(User $user, User $model)
    {
        if ($user->role === 'admin') {
            return true;
        }

        return $model->id === $user->id;
    }

    /**
     * Determine if the user can delete the user.
     */
    public function delete(User $user, User $model)
    {
        if ($user->role === 'admin') {
            return true;
        }

        return $model->id === $user->id;
    }

    /**
     * Determine if the user can restore the user.
     */
    public function restore(User $user, User $model)
    {
        return $this->delete($user, $model);
    }

    /**
     * Determine if the user can permanently delete the user.
     */
    public function forceDelete(User $user, User $model)
    {
        return $this->delete($user, $model);
    }
}
