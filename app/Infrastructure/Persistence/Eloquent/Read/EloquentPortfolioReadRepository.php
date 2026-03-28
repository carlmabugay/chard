<?php

namespace App\Infrastructure\Persistence\Eloquent\Read;

use App\Domain\Common\Query\QueryCriteria;
use App\Domain\Portfolio\Contracts\Read\PortfolioReadRepositoryInterface;
use App\Domain\Portfolio\Entities\Portfolio;
use App\Infrastructure\Persistence\Eloquent\Query\EloquentQueryApplier;
use App\Infrastructure\Persistence\Pagination\LaravelPaginatorAdapter;
use App\Models\Portfolio as PortfolioModel;

class EloquentPortfolioReadRepository implements PortfolioReadRepositoryInterface
{
    public function fetchAll(QueryCriteria $criteria): array
    {
        $query = EloquentQueryApplier::apply(PortfolioModel::query(), $criteria);

        $paginator = $query->paginate(
            perPage: $criteria->per_page,
            page: $criteria->page,
        );

        $result = LaravelPaginatorAdapter::fromPaginator(
            $paginator,
            fn (PortfolioModel $model) => Portfolio::fromEloquentModel($model)
        );

        return $result->toArray();
    }

    public function fetchById(int $id): Portfolio
    {
        $portfolio = PortfolioModel::query()->findOrFail($id);

        return Portfolio::fromEloquentModel($portfolio);
    }
}
