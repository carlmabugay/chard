<?php

namespace App\Domain\TradeLog\Contracts\UseCases;

use App\Application\TradeLog\DTOs\TradeLogDTO;

interface TrashTradeLogInterface
{
    public function handle(TradeLogDTO $dto): ?bool;
}
