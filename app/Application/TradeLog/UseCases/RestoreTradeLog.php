<?php

namespace App\Application\TradeLog\UseCases;

use App\Application\TradeLog\DTOs\TradeLogDTO;
use App\Domain\TradeLog\Contracts\Services\TradeLogServiceInterface;
use App\Domain\TradeLog\Contracts\UseCases\RestoreTradeLogInterface;

class RestoreTradeLog implements RestoreTradeLogInterface
{
    public function __construct(
        protected readonly TradeLogServiceInterface $service,
    ) {}

    public function handle(TradeLogDTO $dto): ?bool
    {
        return $this->service->restore($dto);
    }
}
