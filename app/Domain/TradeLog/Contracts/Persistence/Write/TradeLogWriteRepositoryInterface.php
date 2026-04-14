<?php

namespace App\Domain\TradeLog\Contracts\Persistence\Write;

use App\Application\TradeLog\DTOs\TradeLogDTO;
use App\Domain\TradeLog\Entities\TradeLog;

interface TradeLogWriteRepositoryInterface
{
    public function store(TradeLogDTO $dto): TradeLog;

    public function trash(TradeLogDTO $dto): ?bool;

    public function restore(TradeLogDTO $dto): ?bool;

    public function delete(TradeLogDTO $dto): ?bool;
}
