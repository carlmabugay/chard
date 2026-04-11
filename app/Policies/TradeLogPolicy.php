<?php

namespace App\Policies;

use App\Models\Portfolio;
use App\Models\TradeLog;
use App\Models\User;

class TradeLogPolicy
{
    public function view(User $user, TradeLog $trade_log): bool
    {
        return $user->id === $trade_log->portfolio->user->id;
    }

    public function store(User $user, Portfolio $portfolio): bool
    {
        return $user->id === $portfolio->user->id;
    }

    public function update(User $user, TradeLog $trade_log): bool
    {
        return $user->id === $trade_log->portfolio->user->id;
    }

    public function trash(User $user, TradeLog $trade_log): bool
    {
        return $user->id === $trade_log->portfolio->user->id;
    }

    public function restore(User $user, TradeLog $trade_log): bool
    {
        return $user->id === $trade_log->portfolio->user->id;
    }

    public function destroy(User $user, TradeLog $trade_log): bool
    {
        return $user->id === $trade_log->portfolio->user->id;
    }
}
