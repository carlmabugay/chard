<?php

namespace App\Application\TradeLog\UseCases;

use App\Application\TradeLog\DTOs\TradeLogDTO;
use App\Domain\TradeLog\Contracts\Services\TradeLogServiceInterface;
use App\Domain\TradeLog\Contracts\UseCases\TrashTradeLogInterface;

class TrashTradeLog implements TrashTradeLogInterface
{
    public function __construct(
        protected readonly TradeLogServiceInterface $service
    ) {}

    public function handle(TradeLogDTO $dto): ?bool
    {
        return $this->service->trash($dto);
    }
}
