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

    public function trash(PortfolioModel $portfolio): ?bool
    {
        return $portfolio->query()->delete();
    }

    public function restore(PortfolioModel $portfolio): ?bool
    {
        return $portfolio->query()->restore();
    }

    public function delete(PortfolioModel $portfolio): ?bool
    {
        return $portfolio->query()->forceDelete();
    }
}
