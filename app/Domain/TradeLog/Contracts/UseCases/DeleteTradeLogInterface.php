<?php

namespace App\Domain\TradeLog\Contracts\UseCases;

use App\Models\TradeLog;

interface DeleteTradeLogInterface
{
    public function handle(TradeLog $trade_log): ?bool;
}
