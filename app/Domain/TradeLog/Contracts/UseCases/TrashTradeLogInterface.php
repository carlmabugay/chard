<?php

namespace App\Domain\TradeLog\Contracts\UseCases;

use App\Models\TradeLog as TradeLogModel;

interface TrashTradeLogInterface
{
    public function handle(TradeLogModel $trade_log): ?bool;
}
