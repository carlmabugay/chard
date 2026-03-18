<?php

namespace App\Infrastructure\Persistence\Eloquent\Write;

use App\Domain\Strategy\Contracts\Write\StrategyWriteRepositoryInterface;
use App\Domain\Strategy\Entities\Strategy;
use App\Models\Strategy as StrategyMode;

class EloquentStrategyWriteRepository implements StrategyWriteRepositoryInterface
{
    public function store(Strategy $strategy): Strategy
    {
        $stored_strategy = StrategyMode::query()->updateOrCreate(
            ['id' => $strategy->id()],
            [
                'user_id' => $strategy->userId(),
                'name' => $strategy->name(),
            ]
        );

        return Strategy::fromEloquentModel($stored_strategy);
    }
}
