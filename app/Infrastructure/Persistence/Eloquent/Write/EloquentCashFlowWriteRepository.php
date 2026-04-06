<?php

namespace App\Infrastructure\Persistence\Eloquent\Write;

use App\Domain\CashFlow\Contracts\Write\CashFlowWriteRepositoryInterface;
use App\Domain\CashFlow\Entities\CashFlow;
use App\Models\CashFlow as CashFlowModel;

class EloquentCashFlowWriteRepository implements CashFlowWriteRepositoryInterface
{
    public function store(CashFlow $cash_flow): CashFlow
    {
        $stored_cash_flow = CashFlowModel::query()->updateOrCreate(
            ['id' => $cash_flow->id()],
            [
                'portfolio_id' => $cash_flow->portfolioId(),
                'type' => $cash_flow->type(),
                'amount' => $cash_flow->amount(),
            ]
        );

        return CashFlow::fromEloquentModel($stored_cash_flow);

    }

    /*
     * @throws ModelNotFoundException
     */
    public function trash(int $id): ?bool
    {
        return CashFlowModel::query()->findOrFail($id)->delete();
    }

    /*
     * @throws ModelNotFoundException
     */
    public function restore(int $id): ?bool
    {
        return CashFlowModel::query()->withTrashed()->findOrFail($id)->restore();
    }

    /*
     * @throws ModelNotFoundException
     */
    public function delete(int $id): ?bool
    {
        return CashFlowModel::query()->findOrFail($id)->forceDelete();
    }
}
