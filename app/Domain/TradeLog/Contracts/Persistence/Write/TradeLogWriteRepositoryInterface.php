<?php

namespace App\Domain\TradeLog\Contracts\Persistence\Write;

use App\Application\TradeLog\DTOs\TradeLogDTO;

interface TradeLogWriteRepositoryInterface
{
    public function trash(TradeLogDTO $dto): ?bool;

    public function restore(TradeLogDTO $dto): ?bool;

    public function delete(TradeLogDTO $dto): ?bool;
}
