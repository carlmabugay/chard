<?php

namespace App\Policies;

use App\Models\Portfolio;
use App\Models\User;

class PortfolioPolicy
{
    public function view(User $user, Portfolio $portfolio): bool
    {
        return $user->id === $portfolio->user->id;
    }

    public function update(User $user, Portfolio $portfolio): bool
    {
        return $user->id === $portfolio->user->id;
    }

    public function trash(User $user, Portfolio $portfolio): bool
    {
        return $user->id === $portfolio->user->id;
    }

    public function restore(User $user, Portfolio $portfolio): bool
    {
        return $user->id === $portfolio->user->id;
    }

    public function destroy(User $user, Portfolio $portfolio): bool
    {
        return $user->id === $portfolio->user->id;
    }
}
