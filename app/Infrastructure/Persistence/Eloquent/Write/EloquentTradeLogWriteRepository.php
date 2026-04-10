<?php

namespace App\Infrastructure\Persistence\Eloquent\Write;

use App\Domain\TradeLog\Contracts\Write\TradeLogWriteRepositoryInterface;
use App\Domain\TradeLog\Entities\TradeLog;
use App\Models\TradeLog as TradeLogModel;

class EloquentTradeLogWriteRepository implements TradeLogWriteRepositoryInterface
{
    public function store(TradeLog $trade_log): TradeLog
    {
        $stored_trade_log = TradeLogModel::updateOrCreate(
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

    public function trash(TradeLogModel $trade_log): ?bool
    {
        return $trade_log->delete();
    }

    public function restore(TradeLogModel $trade_log): ?bool
    {
        return $trade_log->restore();
    }

    public function delete(TradeLogModel $trade_log): ?bool
    {
        return $trade_log->forceDelete();
    }
}
