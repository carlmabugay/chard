<?php

namespace App\Infrastructure\Persistence\Eloquent\Write;

use App\Domain\Portfolio\Contracts\Write\PortfolioWriteRepositoryInterface;
use App\Domain\Portfolio\Entities\Portfolio;
use App\Models\Portfolio as PortfolioModel;

class EloquentPortfolioWriteRepository implements PortfolioWriteRepositoryInterface
{
    public function store(Portfolio $portfolio): Portfolio
    {
        $stored_portfolio = PortfolioModel::query()->updateOrCreate(
            ['id' => $portfolio->id()],
            [
                'user_id' => $portfolio->userId(),
                'name' => $portfolio->name(),
            ]
        );

        return Portfolio::fromEloquentModel($stored_portfolio);
    }

    public function trash(int $id): ?bool
    {
        return PortfolioModel::query()->findOrFail($id)->delete();
    }

    public function restore(int $id): ?bool
    {
        return PortfolioModel::query()->withTrashed()->findOrFail($id)->restore();
    }
}
