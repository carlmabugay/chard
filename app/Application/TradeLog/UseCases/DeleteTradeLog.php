<?php

namespace App\Application\TradeLog\UseCases;

use App\Application\TradeLog\DTOs\TradeLogDTO;
use App\Domain\TradeLog\Contracts\Services\TradeLogServiceInterface;
use App\Domain\TradeLog\Contracts\UseCases\DeleteTradeLogInterface;

class DeleteTradeLog implements DeleteTradeLogInterface
{
    public function __construct(
        protected TradeLogServiceInterface $service
    ) {}

    public function handle(TradeLogDTO $dto): ?bool
    {
        return $this->service->delete($dto);
    }
}
