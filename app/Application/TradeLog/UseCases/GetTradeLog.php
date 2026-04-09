<?php

namespace App\Application\TradeLog\UseCases;

use App\Domain\TradeLog\Entities\TradeLog;
use App\Models\TradeLog as TradeLogModel;

class GetTradeLog
{
    public function handle(TradeLogModel $trade_log): TradeLog
    {
        return TradeLog::fromEloquentModel($trade_log);
    }
}
