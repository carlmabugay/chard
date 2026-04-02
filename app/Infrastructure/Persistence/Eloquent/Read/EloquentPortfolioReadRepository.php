<?php

namespace App\Infrastructure\Persistence\Eloquent\Read;

use App\Domain\Common\Query\QueryCriteria;
use App\Domain\Portfolio\Contracts\Read\PortfolioReadRepositoryInterface;
use App\Domain\Portfolio\Entities\Portfolio;
use App\Infrastructure\Persistence\Eloquent\Query\EloquentQueryApplier;
use App\Infrastructure\Persistence\Pagination\LaravelPaginatorAdapter;
use App\Models\Portfolio as PortfolioModel;
use App\Traits\HasEloquentSearchable;

class EloquentPortfolioReadRepository implements PortfolioReadRepositoryInterface
{
    use HasEloquentSearchable;

    const array SEARCHABLE_COLUMNS = [
        'name',
    ];

    public function findAll(QueryCriteria $criteria): array
    {
        $query = EloquentQueryApplier::apply(
            PortfolioModel::query(),
            $criteria,
            fn ($query, $search) => $this->applySearch($query, $search, self::SEARCHABLE_COLUMNS)
        );

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

    public function findById(int $id): Portfolio
    {
        $portfolio = PortfolioModel::query()->findOrFail($id);

        return Portfolio::fromEloquentModel($portfolio);
    }
}
