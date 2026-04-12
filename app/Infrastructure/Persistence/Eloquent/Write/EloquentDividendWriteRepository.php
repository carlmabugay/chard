<?php

namespace App\Infrastructure\Persistence\Eloquent\Write;

use App\Domain\Dividend\Contracts\Persistence\Write\DividendWriteRepositoryInterface;
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

    public function trash(DividendModel $dividend): ?bool
    {
        return $dividend->delete();
    }

    public function restore(DividendModel $dividend): ?bool
    {
        return $dividend->restore();
    }

    public function delete(DividendModel $dividend): ?bool
    {
        return $dividend->forceDelete();
    }
}
