<?php

namespace App\Application\TradeLog\UseCases;

use App\Application\TradeLog\DTOs\StoreTradeLogDTO;
use App\Domain\TradeLog\Contracts\Services\TradeLogServiceInterface;
use App\Domain\TradeLog\Contracts\UseCases\StoreTradeLogInterface;
use App\Domain\TradeLog\Entities\TradeLog;

class StoreTradeLog implements StoreTradeLogInterface
{
    public function __construct(
        private readonly TradeLogServiceInterface $service
    ) {}

    public function handle(StoreTradeLogDTO $dto): TradeLog
    {
        $trade_log = TradeLog::fromDTO($dto);

        return $this->service->store($trade_log);
    }
}
