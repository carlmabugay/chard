<?php

namespace App\Infrastructure\Persistence\Eloquent\Write;

use App\Application\TradeLog\DTOs\TradeLogDTO;
use App\Domain\TradeLog\Contracts\Persistence\Write\TradeLogWriteRepositoryInterface;
use App\Domain\TradeLog\Entities\TradeLog;
use App\Models\TradeLog as TradeLogModel;

class EloquentTradeLogWriteRepository implements TradeLogWriteRepositoryInterface
{
    public function store(TradeLogDTO $dto): TradeLog
    {
        $stored_trade_log = TradeLogModel::updateOrCreate(
            ['id' => $dto->id()],
            [
                'portfolio_id' => $dto->portfolioId(),
                'symbol' => $dto->symbol(),
                'type' => $dto->type(),
                'price' => $dto->price(),
                'shares' => $dto->shares(),
                'fees' => $dto->fees(),
            ]
        );

        return TradeLog::fromEloquentModel($stored_trade_log);
    }

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
