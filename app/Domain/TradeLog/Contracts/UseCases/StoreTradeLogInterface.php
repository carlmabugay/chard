<?php

namespace App\Domain\TradeLog\Contracts\UseCases;

use App\Application\TradeLog\DTOs\StoreTradeLogDTO;
use App\Domain\TradeLog\Entities\TradeLog;

interface StoreTradeLogInterface
{
    public function handle(StoreTradeLogDTO $dto): TradeLog;
}
