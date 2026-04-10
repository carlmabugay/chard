<?php

namespace App\Policies;

use App\Models\CashFlow;
use App\Models\User;

class CashFlowPolicy
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
    public function view(User $user, CashFlow $cash_flow): bool
    {
        return $user->id === $cash_flow->portfolio->user->id;
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
    public function update(User $user, CashFlow $cash_flow): bool
    {
        return $user->id === $cash_flow->portfolio->user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function trash(User $user, CashFlow $cash_flow): bool
    {
        return $user->id === $cash_flow->portfolio->user->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CashFlow $cash_flow): bool
    {
        return $user->id === $cash_flow->portfolio->user->id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function destroy(User $user, CashFlow $cash_flow): bool
    {
        return $user->id === $cash_flow->portfolio->user->id;
    }
}
