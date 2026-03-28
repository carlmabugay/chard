<?php

namespace App\Infrastructure\Persistence\Eloquent\Read;

use App\Domain\Portfolio\Contracts\Read\PortfolioReadRepositoryInterface;
use App\Domain\Portfolio\Entities\Portfolio;
use App\Infrastructure\Persistence\Pagination\LaravelPaginatorAdapter;
use App\Models\Portfolio as PortfolioModel;

class EloquentPortfolioReadRepository implements PortfolioReadRepositoryInterface
{
    public function fetchAll(): array
    {
        $paginator = PortfolioModel::query()->paginate();

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
