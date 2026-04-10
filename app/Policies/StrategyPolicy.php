<?php

namespace App\Policies;

use App\Models\Strategy;
use App\Models\User;

class StrategyPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Strategy $strategy): bool
    {
        return $user->id === $strategy->user->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Strategy $strategy): bool
    {
        return $user->id === $strategy->user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function trash(User $user, Strategy $strategy): bool
    {
        return $user->id === $strategy->user->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Strategy $strategy): bool
    {
        return $user->id === $strategy->user->id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function destroy(User $user, Strategy $strategy): bool
    {
        return $user->id === $strategy->user->id;
    }
}
