<?php

namespace App\Infrastructure\Persistence\Eloquent\Read;

use App\Domain\Dividend\Contracts\Read\DividendReadRepositoryInterface;
use App\Domain\Dividend\Entities\Dividend;
use App\Infrastructure\Persistence\Pagination\LaravelPaginatorAdapter;
use App\Models\Dividend as DividendModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EloquentDividendReadRepository implements DividendReadRepositoryInterface
{
    public function findAll(array $columns = ['*']): array
    {
        $paginator = DividendModel::query()
            ->select($columns)
            ->with('portfolio')
            ->paginate();

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
