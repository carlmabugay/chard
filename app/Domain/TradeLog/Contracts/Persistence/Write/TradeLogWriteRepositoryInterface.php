<?php

namespace App\Domain\TradeLog\Contracts\Persistence\Write;

use App\Application\TradeLog\DTOs\TradeLogDTO;

interface TradeLogWriteRepositoryInterface
{
    public function delete(TradeLogDTO $dto): ?bool;
}
