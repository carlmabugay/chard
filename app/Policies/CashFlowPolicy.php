<?php

namespace App\Policies;

use App\Models\CashFlow;
use App\Models\User;

class CashFlowPolicy
{
    public function view(User $user, CashFlow $cash_flow): bool
    {
        return $user->id === $cash_flow->portfolio->user->id;
    }

    public function update(User $user, CashFlow $cash_flow): bool
    {
        return $user->id === $cash_flow->portfolio->user->id;
    }

    public function trash(User $user, CashFlow $cash_flow): bool
    {
        return $user->id === $cash_flow->portfolio->user->id;
    }

    public function restore(User $user, CashFlow $cash_flow): bool
    {
        return $user->id === $cash_flow->portfolio->user->id;
    }

    public function destroy(User $user, CashFlow $cash_flow): bool
    {
        return $user->id === $cash_flow->portfolio->user->id;
    }
}
