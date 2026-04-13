<?php

namespace App\Infrastructure\Persistence\Eloquent\Write;

use App\Application\CashFlow\DTOs\CashFlowDTO;
use App\Domain\CashFlow\Contracts\Persistence\Write\CashFlowWriteRepositoryInterface;
use App\Domain\CashFlow\Entities\CashFlow;
use App\Models\CashFlow as CashFlowModel;

class EloquentCashFlowWriteRepository implements CashFlowWriteRepositoryInterface
{
    public function store(CashFlowDTO $dto): CashFlow
    {
        $stored_cash_flow = CashFlowModel::query()->updateOrCreate(
            ['id' => $dto->id()],
            [
                'portfolio_id' => $dto->portfolioId(),
                'type' => $dto->type(),
                'amount' => $dto->amount(),
            ]
        );

        return CashFlow::fromEloquentModel($stored_cash_flow);

    }

    public function trash(CashFlowDTO $dto): ?bool
    {
        return CashFlowModel::find($dto->id())->delete();
    }

    public function restore(CashFlowDTO $dto): ?bool
    {
        return CashFlowModel::onlyTrashed()->find($dto->id())->restore();
    }

    public function delete(CashFlowDTO $dto): ?bool
    {
        return CashFlowModel::find($dto->id())->forceDelete();
    }
}
