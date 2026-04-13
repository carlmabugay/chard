<?php

namespace App\Infrastructure\Persistence\Eloquent\Write;

use App\Application\Portolio\DTOs\PortfolioDTO;
use App\Domain\Portfolio\Contracts\Persistence\Write\PortfolioWriteRepositoryInterface;
use App\Domain\Portfolio\Entities\Portfolio;
use App\Models\Portfolio as PortfolioModel;

class EloquentPortfolioWriteRepository implements PortfolioWriteRepositoryInterface
{
    public function store(PortfolioDTO $dto): Portfolio
    {
        $stored_portfolio = PortfolioModel::query()->updateOrCreate(
            ['id' => $dto->id()],
            [
                'user_id' => $dto->userId(),
                'name' => $dto->name(),
            ]
        );

        return Portfolio::fromEloquentModel($stored_portfolio);
    }

    public function trash(PortfolioDTO $dto): ?bool
    {
        return PortfolioModel::find($dto->id())->delete();
    }

    public function restore(PortfolioDTO $dto): ?bool
    {
        return PortfolioModel::onlyTrashed()->find($dto->id())->restore();
    }

    public function delete(PortfolioDTO $dto): ?bool
    {
        return PortfolioModel::find($dto->id())->forceDelete();
    }
}
