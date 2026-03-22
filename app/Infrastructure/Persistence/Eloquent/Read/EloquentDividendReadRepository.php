<?php

namespace App\Infrastructure\Persistence\Eloquent\Read;

use App\Domain\Dividend\Contracts\Read\DividendReadRepositoryInterface;
use App\Domain\Dividend\Entities\Dividend;
use App\Models\Dividend as DividendModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EloquentDividendReadRepository implements DividendReadRepositoryInterface
{
    public function findAll(): array
    {
        return DividendModel::query()
            ->get()
            ->map(fn (DividendModel $model) => Dividend::fromEloquentModel($model))
            ->all();
    }

    /**
     * @throws ModelNotFoundException
     */
    public function findById(int $id): Dividend
    {
        $dividend = DividendModel::query()->findOrFail($id);

        return Dividend::fromEloquentModel($dividend);
    }
}
