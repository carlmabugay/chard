<?php

namespace App\Domain\TradeLog\Contracts\Services;

use App\Application\TradeLog\DTOs\TradeLogDTO;
use App\Domain\TradeLog\Entities\TradeLog;

interface TradeLogServiceInterface
{
    public function findById(int $id): TradeLog;

    public function store(TradeLogDTO $dto): TradeLog;

    public function trash(TradeLogDTO $dto): ?bool;

    public function restore(TradeLogDTO $dto): ?bool;

    public function delete(TradeLogDTO $dto): ?bool;
}
