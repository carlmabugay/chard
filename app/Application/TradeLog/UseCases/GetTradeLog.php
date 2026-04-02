<?php

namespace App\Application\TradeLog\UseCases;

use App\Domain\TradeLog\Entities\TradeLog;
use App\Domain\TradeLog\Services\TradeLogService;

class GetTradeLog
{
    public function __construct(
        protected TradeLogService $service
    ) {}

    public function handle(int $id): TradeLog
    {
        return $this->service->findById($id);
    }
}
