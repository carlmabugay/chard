<?php

namespace App\Domain\TradeLog\Contracts\UseCases;

use App\Domain\TradeLog\Entities\TradeLog;
use App\Models\TradeLog as TradeLogModel;

interface GetTradeLogInterface
{
    public function handle(TradeLogModel $trade_log): TradeLog;
}
