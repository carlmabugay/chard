<?php

namespace App\Application\TradeLog\UseCases;

use App\Domain\TradeLog\Contracts\Services\TradeLogServiceInterface;
use App\Domain\TradeLog\Contracts\UseCases\DeleteTradeLogInterface;
use App\Models\TradeLog;

class DeleteTradeLog implements DeleteTradeLogInterface
{
    public function __construct(
        protected TradeLogServiceInterface $service
    ) {}

    public function handle(TradeLog $trade_log): ?bool
    {
        return $this->service->delete($trade_log);
    }
}
