<?php

namespace App\Infrastructure\Persistence\Eloquent\Read;

use App\Domain\CashFlow\Contracts\Read\CashFlowReadRepositoryInterface;
use App\Domain\CashFlow\Entities\CashFlow;
use App\Models\CashFlow as CashFlowModel;

class EloquentCashFlowReadRepository implements CashFlowReadRepositoryInterface
{
    public function findAll(): array
    {
        return CashFlowModel::query()
            ->get()
            ->map(fn (CashFlowModel $model) => CashFlow::fromEloquentModel($model))
            ->all();
    }

    public function findById(int $id): CashFlow
    {
        $cash_flow = CashFlowModel::query()
            ->with(['portfolio'])
            ->findOrFail($id);

        return CashFlow::fromEloquentModel($cash_flow);
    }
}
