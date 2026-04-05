<?php

namespace App\Application\TradeLog\UseCases;

use App\Domain\TradeLog\Services\TradeLogService;

class RestoreTradeLog
{
    public function __construct(
        protected readonly TradeLogService $service,
    ) {}

    public function handle(int $id): ?bool
    {
        return $this->service->restore($id);
    }
}
