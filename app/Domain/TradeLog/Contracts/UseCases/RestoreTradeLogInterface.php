<?php

namespace App\Domain\TradeLog\Contracts\UseCases;

use App\Application\TradeLog\DTOs\TradeLogDTO;

interface RestoreTradeLogInterface
{
    public function handle(TradeLogDTO $dto): ?bool;
}
