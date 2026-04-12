<?php

namespace App\Infrastructure\Persistence\Eloquent\Read;

use App\Domain\CashFlow\Contracts\Persistence\Read\CashFlowReadRepositoryInterface;
use App\Domain\CashFlow\Entities\CashFlow;
use App\Domain\Common\Query\QueryCriteria;
use App\Infrastructure\Persistence\Eloquent\Query\EloquentQueryApplier;
use App\Infrastructure\Persistence\Pagination\LaravelPaginatorAdapter;
use App\Models\CashFlow as CashFlowModel;
use App\Traits\HasEloquentSearchable;

class EloquentCashFlowReadRepository implements CashFlowReadRepositoryInterface
{
    use HasEloquentSearchable;

    const array SEARCHABLE_COLUMNS = [
        'type',
        'amount',
    ];

    public function findAll(QueryCriteria $criteria): array
    {
        $query = CashFlowModel::query()->with('portfolio');

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
            fn (CashFlowModel $model) => CashFlow::fromEloquentModel($model)
        );

        return $result->toArray();
    }

    public function findById(int $id): CashFlow
    {
        $cash_flow = CashFlowModel::query()
            ->with(['portfolio'])
            ->findOrFail($id);

        return CashFlow::fromEloquentModel($cash_flow);
    }
}
