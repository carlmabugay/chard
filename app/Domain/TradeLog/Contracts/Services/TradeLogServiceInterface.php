<?php

namespace App\Domain\TradeLog\Contracts\Services;

use App\Application\TradeLog\DTOs\TradeLogDTO;

interface TradeLogServiceInterface
{
    public function delete(TradeLogDTO $dto): ?bool;
}
