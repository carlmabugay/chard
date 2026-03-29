<?php

namespace App\Infrastructure\Persistence\Eloquent\Read;

use App\Domain\Common\Query\QueryCriteria;
use App\Domain\Strategy\Contracts\Read\StrategyReadRepositoryInterface;
use App\Domain\Strategy\Entities\Strategy;
use App\Infrastructure\Persistence\Eloquent\Query\EloquentQueryApplier;
use App\Infrastructure\Persistence\Pagination\LaravelPaginatorAdapter;
use App\Models\Strategy as StrategyModel;
use App\Traits\HasEloquentSearchable;

class EloquentStrategyReadRepository implements StrategyReadRepositoryInterface
{
    use HasEloquentSearchable;

    const array SEARCHABLE_COLUMNS = [
        'name',
    ];

    public function fetchAll(QueryCriteria $criteria): array
    {
        $query = EloquentQueryApplier::apply(
            StrategyModel::query(),
            $criteria,
            fn ($query, $search) => $this->applySearch($criteria, $search, self::SEARCHABLE_COLUMNS)
        );

        $paginator = $query->paginate(
            perPage: $criteria->per_page,
            page: $criteria->page,
        );

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
