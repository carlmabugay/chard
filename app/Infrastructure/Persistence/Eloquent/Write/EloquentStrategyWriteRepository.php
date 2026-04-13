<?php

namespace App\Infrastructure\Persistence\Eloquent\Write;

use App\Application\Strategy\DTOs\StrategyDTO;
use App\Domain\Strategy\Contracts\Persistence\Write\StrategyWriteRepositoryInterface;
use App\Domain\Strategy\Entities\Strategy;
use App\Models\Strategy as StrategyModel;

class EloquentStrategyWriteRepository implements StrategyWriteRepositoryInterface
{
    public function store(StrategyDTO $dto): Strategy
    {
        $stored_strategy = StrategyModel::query()->updateOrCreate(
            ['id' => $dto->id()],
            [
                'user_id' => $dto->userId(),
                'name' => $dto->name(),
            ]
        );

        return Strategy::fromEloquentModel($stored_strategy);
    }

    public function trash(StrategyDTO $dto): ?bool
    {
        return StrategyModel::find($dto->id())->delete();
    }

    public function restore(StrategyDTO $dto): ?bool
    {
        return StrategyModel::onlyTrashed()->find($dto->id())->restore();
    }

    public function delete(StrategyDTO $dto): ?bool
    {
        return StrategyModel::find($dto->id())->forceDelete();
    }
}
