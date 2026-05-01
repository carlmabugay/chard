<?php

namespace App\Infrastructure\Persistence\Eloquent\Write;

use App\Application\Dividend\DTOs\DividendDTO;
use App\Domain\Dividend\Contracts\Persistence\Write\DividendWriteRepositoryInterface;
use App\Models\Dividend as DividendModel;

class EloquentDividendWriteRepository implements DividendWriteRepositoryInterface
{
    public function delete(DividendDTO $dto): ?bool
    {
        return DividendModel::find($dto->id())->forceDelete();
    }
}
