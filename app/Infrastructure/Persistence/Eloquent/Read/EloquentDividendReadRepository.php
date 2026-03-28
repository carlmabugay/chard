<?php

namespace App\Infrastructure\Persistence\Eloquent\Read;

use App\Domain\Common\Query\QueryCriteria;
use App\Domain\Dividend\Contracts\Read\DividendReadRepositoryInterface;
use App\Domain\Dividend\Entities\Dividend;
use App\Infrastructure\Persistence\Eloquent\Query\EloquentQueryApplier;
use App\Infrastructure\Persistence\Pagination\LaravelPaginatorAdapter;
use App\Models\Dividend as DividendModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EloquentDividendReadRepository implements DividendReadRepositoryInterface
{
    public function findAll(QueryCriteria $criteria): array
    {
        $query = DividendModel::query()->with('portfolio');

        $query = EloquentQueryApplier::apply($query, $criteria);

        $paginator = $query->paginate(
            perPage: $criteria->per_page,
            page: $criteria->page,
        );

        $result = LaravelPaginatorAdapter::fromPaginator(
            $paginator,
            fn (DividendModel $model) => Dividend::fromEloquentModel($model)
        );

        return $result->toArray();
    }

    /**
     * @throws ModelNotFoundException
     */
    public function findById(int $id): Dividend
    {
        $dividend = DividendModel::query()
            ->with(['portfolio'])
            ->findOrFail($id);

        return Dividend::fromEloquentModel($dividend);
    }
}
