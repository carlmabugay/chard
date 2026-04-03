<?php

namespace App\Domain\TradeLog\Contracts\Write;

use App\Domain\TradeLog\Entities\TradeLog;

interface TradeLogWriteRepositoryInterface
{
    public function store(TradeLog $trade_log): TradeLog;
}
