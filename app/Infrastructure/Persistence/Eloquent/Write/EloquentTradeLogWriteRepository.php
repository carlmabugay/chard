<?php

namespace App\Infrastructure\Persistence\Eloquent\Write;

use App\Application\TradeLog\DTOs\TradeLogDTO;
use App\Domain\TradeLog\Contracts\Persistence\Write\TradeLogWriteRepositoryInterface;
use App\Models\TradeLog as TradeLogModel;

class EloquentTradeLogWriteRepository implements TradeLogWriteRepositoryInterface
{
    public function trash(TradeLogDTO $dto): ?bool
    {
        return TradeLogModel::find($dto->id())->delete();
    }

    public function restore(TradeLogDTO $dto): ?bool
    {
        return TradeLogModel::onlyTrashed()->find($dto->id())->restore();
    }

    public function delete(TradeLogDTO $dto): ?bool
    {
        return TradeLogModel::find($dto->id())->forceDelete();
    }
}
