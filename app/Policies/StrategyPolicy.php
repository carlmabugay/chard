<?php

namespace App\Policies;

use App\Models\Strategy;
use App\Models\User;

class StrategyPolicy
{
    public function view(User $user, Strategy $strategy): bool
    {
        return $user->id === $strategy->user->id;
    }

    public function update(User $user, Strategy $strategy): bool
    {
        return $user->id === $strategy->user->id;
    }

    public function trash(User $user, Strategy $strategy): bool
    {
        return $user->id === $strategy->user->id;
    }

    public function restore(User $user, Strategy $strategy): bool
    {
        return $user->id === $strategy->user->id;
    }

    public function destroy(User $user, Strategy $strategy): bool
    {
        return $user->id === $strategy->user->id;
    }
}
