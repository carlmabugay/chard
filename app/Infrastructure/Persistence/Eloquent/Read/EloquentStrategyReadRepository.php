<?php

namespace App\Infrastructure\Persistence\Eloquent\Read;

use App\Domain\Strategy\Contracts\Read\StrategyReadRepositoryInterface;
use App\Domain\Strategy\Entities\Strategy;
use App\Infrastructure\Persistence\Pagination\LaravelPaginatorAdapter;
use App\Models\Strategy as StrategyModel;

class EloquentStrategyReadRepository implements StrategyReadRepositoryInterface
{
    public function fetchAll(): array
    {

        $paginator = StrategyModel::query()->paginate();

        $result = LaravelPaginatorAdapter::fromPaginator(
            $paginator,
            fn (StrategyModel $model) => Strategy::fromEloquentModel($model)
        );

        return $result->toArray();
    }

    public function fetchById(int $id): Strategy
    {
        $strategy_model = StrategyModel::query()->findOrFail($id);

        return Strategy::fromEloquentModel($strategy_model);
    }
}
