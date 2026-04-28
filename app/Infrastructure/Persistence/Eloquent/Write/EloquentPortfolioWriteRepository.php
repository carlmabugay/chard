<?php

namespace App\Infrastructure\Persistence\Eloquent\Write;

use App\Application\Portolio\DTOs\PortfolioDTO;
use App\Domain\Portfolio\Contracts\Persistence\Write\PortfolioWriteRepositoryInterface;
use App\Models\Portfolio as PortfolioModel;

class EloquentPortfolioWriteRepository implements PortfolioWriteRepositoryInterface
{
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
