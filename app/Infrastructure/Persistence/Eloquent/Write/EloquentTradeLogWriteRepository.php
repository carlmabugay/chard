<?php

namespace App\Infrastructure\Persistence\Eloquent\Write;

use App\Domain\TradeLog\Contracts\Write\TradeLogWriteRepositoryInterface;
use App\Domain\TradeLog\Entities\TradeLog;
use App\Models\TradeLog as TradeLogModel;

class EloquentTradeLogWriteRepository implements TradeLogWriteRepositoryInterface
{
    public function store(TradeLog $trade_log): TradeLog
    {
        $stored_trade_log = TradeLogModel::query()->updateOrCreate(
            ['id' => $trade_log->id()],
            [
                'portfolio_id' => $trade_log->portfolioId(),
                'symbol' => $trade_log->symbol(),
                'type' => $trade_log->type(),
                'price' => $trade_log->price(),
                'shares' => $trade_log->shares(),
                'fees' => $trade_log->fees(),
            ]
        );

        return TradeLog::fromEloquentModel($stored_trade_log);
    }

    public function trash(int $id): ?bool
    {
        return TradeLogModel::query()->findOrFail($id)->delete();
    }

    /*
     * throws ModelNotFoundException
     */
    public function restore(int $id): ?bool
    {
        return TradeLogModel::query()->withTrashed()->findOrFail($id)->restore();
    }
}
