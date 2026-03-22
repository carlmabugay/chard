<?php

namespace App\Infrastructure\Persistence\Eloquent\Read;

use App\Domain\Dividend\Contracts\Read\DividendReadRepositoryInterface;
use App\Domain\Dividend\Entities\Dividend;
use App\Models\Dividend as DividendModel;

class EloquentDividendReadRepository implements DividendReadRepositoryInterface
{
    public function findAll(): array
    {
        return DividendModel::query()
            ->get()
            ->map(fn (DividendModel $model) => Dividend::fromEloquentModel($model))
            ->all();
    }
}
