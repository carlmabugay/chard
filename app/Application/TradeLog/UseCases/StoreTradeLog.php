<?php

namespace App\Application\TradeLog\UseCases;

use App\Application\TradeLog\DTOs\StoreTradeLogDTO;
use App\Domain\TradeLog\Entities\TradeLog;
use App\Domain\TradeLog\Services\TradeLogService;

class StoreTradeLog
{
    public function __construct(
        private readonly TradeLogService $service
    ) {}

    public function handle(StoreTradeLogDTO $dto): TradeLog
    {
        $trade_log = TradeLog::fromDTO($dto);

        return $this->service->store($trade_log);
    }
}
