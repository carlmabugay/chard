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
            ->map(fn ($model) => $this->toDomain($model))
            ->all();
    }

    public function fetchById(int $id): Portfolio
    {
        $portfolio = PortfolioModel::query()->findOrFail($id);

        return $this->toDomain($portfolio);
    }

    public function toDomain(PortfolioModel $portfolio): Portfolio
    {
        return new Portfolio(
            user_id: $portfolio->user_id,
            id: $portfolio->id,
            name: $portfolio->name,
            created_at: $portfolio->created_at,
            updated_at: $portfolio->updated_at,
        );
    }
}
