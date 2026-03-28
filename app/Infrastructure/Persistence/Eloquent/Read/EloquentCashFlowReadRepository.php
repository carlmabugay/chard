<?php

namespace App\Infrastructure\Persistence\Eloquent\Read;

use App\Domain\CashFlow\Contracts\Read\CashFlowReadRepositoryInterface;
use App\Domain\CashFlow\Entities\CashFlow;
use App\Infrastructure\Persistence\Pagination\LaravelPaginatorAdapter;
use App\Models\CashFlow as CashFlowModel;

class EloquentCashFlowReadRepository implements CashFlowReadRepositoryInterface
{
    public function findAll(): array
    {
        $paginator = CashFlowModel::query()->with('portfolio')->paginate();

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
