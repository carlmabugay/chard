<?php

namespace App\Infrastructure\Persistence\Eloquent\Write;

use App\Domain\Portfolio\Contracts\Write\PortfolioWriteRepositoryInterface;
use App\Domain\Portfolio\Entities\Portfolio;
use App\Models\Portfolio as PortfolioModel;

class EloquentPortfolioWriteRepository implements PortfolioWriteRepositoryInterface
{
    public function store(Portfolio $portfolio): void
    {
        PortfolioModel::query()->updateOrCreate(
            ['id' => $portfolio->id()],
            [
                'user_id' => $portfolio->userId(),
                'name' => $portfolio->name(),
            ]
        );
    }
}
