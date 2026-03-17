<?php

namespace App\Infrastructure\Persistence\Eloquent\Read;

use App\Domain\Strategy\Contracts\Read\StrategyReadRepositoryInterface;
use App\Domain\Strategy\Entities\Strategy;
use App\Models\Strategy as StrategyModel;

class EloquentStrategyReadRepository implements StrategyReadRepositoryInterface
{
    public function fetchAll(): array
    {
        return StrategyModel::query()
            ->get()
            ->map(fn ($model) => Strategy::fromEloquentModel($model))
            ->all();
    }
}
