<?php

namespace App\Infrastructure\Persistence\Eloquent\Read;

use App\Domain\TradeLog\Contracts\Persistence\Read\TradeLogReadRepositoryInterface;
use App\Domain\TradeLog\Entities\TradeLog;
use App\Models\TradeLog as TradeLogModel;

class EloquentTradeLogReadRepository implements TradeLogReadRepositoryInterface
{
    public function findById(int $id): TradeLog
    {
        $trade_log = TradeLogModel::query()
            ->with(['portfolio'])
            ->findOrFail($id);

        return TradeLog::fromEloquentModel($trade_log);
    }
}
