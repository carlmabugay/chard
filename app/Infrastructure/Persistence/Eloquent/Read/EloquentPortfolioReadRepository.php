<?php

namespace App\Infrastructure\Persistence\Eloquent\Read;

use App\Domain\Portfolio\Contracts\Read\PortfolioReadRepositoryInterface;
use App\Domain\Portfolio\Entities\Portfolio;
use App\Models\Portfolio as PortfolioModel;

class EloquentPortfolioReadRepository implements PortfolioReadRepositoryInterface
{
    public function fetchAll(): array
    {
        return PortfolioModel::query()
            ->get()
            ->map(fn ($model) => Portfolio::fromEloquentModel($model))
            ->all();
    }

    public function fetchById(int $id): Portfolio
    {
        $portfolio = PortfolioModel::query()->findOrFail($id);

        return Portfolio::fromEloquentModel($portfolio);
    }
}
