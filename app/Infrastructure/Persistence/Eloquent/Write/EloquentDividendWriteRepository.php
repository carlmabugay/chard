<?php

namespace App\Infrastructure\Persistence\Eloquent\Write;

use App\Application\Dividend\DTOs\DividendDTO;
use App\Domain\Dividend\Contracts\Persistence\Write\DividendWriteRepositoryInterface;
use App\Domain\Dividend\Entities\Dividend;
use App\Models\Dividend as DividendModel;

class EloquentDividendWriteRepository implements DividendWriteRepositoryInterface
{
    public function store(DividendDTO $dto): Dividend
    {
        $stored_dividend = DividendModel::query()->updateOrCreate(
            ['id' => $dto->id()],
            [
                'portfolio_id' => $dto->portfolioId(),
                'symbol' => $dto->symbol(),
                'amount' => $dto->amount(),
                'recorded_at' => $dto->recordedAt(),
            ],
        );

        return Dividend::fromEloquentModel($stored_dividend);
    }

    public function trash(DividendDTO $dto): ?bool
    {
        return DividendModel::find($dto->id())->delete();
    }

    public function restore(DividendDTO $dto): ?bool
    {
        return DividendModel::onlyTrashed()->find($dto->id())->restore();
    }

    public function delete(DividendDTO $dto): ?bool
    {
        return DividendModel::find($dto->id())->forceDelete();
    }
}
