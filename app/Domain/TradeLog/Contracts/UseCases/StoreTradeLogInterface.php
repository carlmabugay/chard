<?php

namespace App\Domain\TradeLog\Contracts\UseCases;

use App\Application\TradeLog\DTOs\TradeLogDTO;
use App\Domain\TradeLog\Entities\TradeLog;

interface StoreTradeLogInterface
{
    public function handle(TradeLogDTO $dto): TradeLog;
}
