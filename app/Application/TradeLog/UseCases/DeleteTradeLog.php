<?php

namespace App\Application\TradeLog\UseCases;

use App\Domain\TradeLog\Services\TradeLogService;

class DeleteTradeLog
{
    public function __construct(
        protected TradeLogService $service
    ) {}

    public function handle(int $id): ?bool
    {
        return $this->service->delete($id);
    }
}
