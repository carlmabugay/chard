<?php

namespace App\Policies;

use App\Models\Dividend;
use App\Models\Portfolio;
use App\Models\User;

class DividendPolicy
{
    public function view(User $user, Dividend $dividend): bool
    {
        return $user->id === $dividend->portfolio->user->id;
    }

    public function store(User $user, Portfolio $portfolio): bool
    {
        return $user->id === $portfolio->user->id;
    }

    public function update(User $user, Dividend $dividend): bool
    {
        return $user->id === $dividend->portfolio->user->id;
    }

    public function trash(User $user, Dividend $dividend): bool
    {
        return $user->id === $dividend->portfolio->user->id;
    }

    public function restore(User $user, Dividend $dividend): bool
    {
        return $user->id === $dividend->portfolio->user->id;
    }

    public function destroy(User $user, Dividend $dividend): bool
    {
        return $user->id === $dividend->portfolio->user->id;
    }
}
