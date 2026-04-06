<?php

namespace App\Domain\TradeLog\Contracts\Write;

use App\Domain\TradeLog\Entities\TradeLog;

interface TradeLogWriteRepositoryInterface
{
    public function store(TradeLog $trade_log): TradeLog;

    public function trash(int $id): ?bool;

    public function restore(int $id): ?bool;

    public function delete(int $id): ?bool;
}
