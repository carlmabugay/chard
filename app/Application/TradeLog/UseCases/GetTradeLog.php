<?php

namespace App\Application\TradeLog\UseCases;

use App\Domain\TradeLog\Contracts\UseCases\GetTradeLogInterface;
use App\Domain\TradeLog\Entities\TradeLog;
use App\Models\TradeLog as TradeLogModel;

class GetTradeLog implements GetTradeLogInterface
{
    public function handle(TradeLogModel $trade_log): TradeLog
    {
        return TradeLog::fromEloquentModel($trade_log);
    }
}
