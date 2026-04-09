<?php

namespace App\Application\TradeLog\UseCases;

use App\Domain\TradeLog\Services\TradeLogService;
use App\Models\TradeLog as TradeLogModel;

class RestoreTradeLog
{
    public function __construct(
        protected readonly TradeLogService $service,
    ) {}

    public function handle(TradeLogModel $trade_log): ?bool
    {
        return $this->service->restore($trade_log);
    }
}
