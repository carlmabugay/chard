<?php

namespace App\Infrastructure\Persistence\Eloquent\Write;

use App\Domain\Dividend\Contracts\Write\DividendWriteRepositoryInterface;
use App\Domain\Dividend\Entities\Dividend;
use App\Models\Dividend as DividendModel;

class EloquentDividendWriteRepository implements DividendWriteRepositoryInterface
{
    public function store(Dividend $dividend): Dividend
    {
        $stored_dividend = DividendModel::query()->updateOrCreate(
            ['id' => $dividend->id()],
            [
                'portfolio_id' => $dividend->portfolioId(),
                'symbol' => $dividend->symbol(),
                'amount' => $dividend->amount(),
                'recorded_at' => $dividend->recordedAt(),
            ],
        );

        return Dividend::fromEloquentModel($stored_dividend);
    }

    public function trash(int $id): ?bool
    {
        return DividendModel::query()->findOrFail($id)->delete();
    }

    /*
     * @throws ModelNotFoundException
     */
    public function restore(int $id): ?bool
    {
        return DividendModel::query()->withTrashed()->findOrFail($id)->restore();
    }
}
