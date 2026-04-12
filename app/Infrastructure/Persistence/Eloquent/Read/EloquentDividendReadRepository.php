<?php

namespace App\Infrastructure\Persistence\Eloquent\Read;

use App\Domain\Common\Query\QueryCriteria;
use App\Domain\Dividend\Contracts\Persistence\Read\DividendReadRepositoryInterface;
use App\Domain\Dividend\Entities\Dividend;
use App\Infrastructure\Persistence\Eloquent\Query\EloquentQueryApplier;
use App\Infrastructure\Persistence\Pagination\LaravelPaginatorAdapter;
use App\Models\Dividend as DividendModel;
use App\Traits\HasEloquentSearchable;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EloquentDividendReadRepository implements DividendReadRepositoryInterface
{
    use HasEloquentSearchable;

    const array SEARCHABLE_COLUMNS = [
        'symbol',
        'amount',
    ];

    public function findAll(QueryCriteria $criteria): array
    {
        $query = DividendModel::query()->with('portfolio');

        $query = EloquentQueryApplier::apply(
            query: $query,
            criteria: $criteria,
            searchCallback: fn ($query, $search) => $this->applySearch($query, $search, self::SEARCHABLE_COLUMNS)
        );

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
