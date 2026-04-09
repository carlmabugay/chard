<?php

namespace App\Application\TradeLog\UseCases;

use App\Domain\TradeLog\Services\TradeLogService;
use App\Models\TradeLog;

class DeleteTradeLog
{
    public function __construct(
        protected TradeLogService $service
    ) {}

    public function handle(TradeLog $trade_log): ?bool
    {
        return $this->service->delete($trade_log);
    }
}
