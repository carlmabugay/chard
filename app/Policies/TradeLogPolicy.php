<?php

namespace App\Policies;

use App\Models\TradeLog;
use App\Models\User;

class TradeLogPolicy
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
    public function view(User $user, TradeLog $trade_log): bool
    {
        return $user->id === $trade_log->portfolio->user->id;
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
    public function update(User $user, TradeLog $trade_log): bool
    {
        return $user->id === $trade_log->portfolio->user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function trash(User $user, TradeLog $trade_log): bool
    {
        return $user->id === $trade_log->portfolio->user->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, TradeLog $trade_log): bool
    {
        return $user->id === $trade_log->portfolio->user->id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function destroy(User $user, TradeLog $trade_log): bool
    {
        return $user->id === $trade_log->portfolio->user->id;
    }
}
