<?php

namespace App\Application\TradeLog\UseCases;

use App\Domain\TradeLog\Contracts\Services\TradeLogServiceInterface;
use App\Domain\TradeLog\Contracts\UseCases\RestoreTradeLogInterface;
use App\Models\TradeLog as TradeLogModel;

class RestoreTradeLog implements RestoreTradeLogInterface
{
    public function __construct(
        protected readonly TradeLogServiceInterface $service,
    ) {}

    public function handle(TradeLogModel $trade_log): ?bool
    {
        return $this->service->restore($trade_log);
    }
}
