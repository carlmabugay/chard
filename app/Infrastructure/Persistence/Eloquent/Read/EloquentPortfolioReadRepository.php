<?php

namespace App\Infrastructure\Persistence\Eloquent\Read;

use App\Domain\Portfolio\Contracts\Persistence\Read\PortfolioReadRepositoryInterface;
use App\Domain\Portfolio\Entities\Portfolio;
use App\Models\Portfolio as PortfolioModel;

class EloquentPortfolioReadRepository implements PortfolioReadRepositoryInterface
{
    public function findById(int $id): Portfolio
    {
        $portfolio = PortfolioModel::query()->findOrFail($id);

        return Portfolio::fromEloquentModel($portfolio);
    }
}
