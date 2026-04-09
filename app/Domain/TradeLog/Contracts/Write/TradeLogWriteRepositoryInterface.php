<?php

namespace App\Domain\TradeLog\Contracts\Write;

use App\Domain\TradeLog\Entities\TradeLog;
use App\Models\TradeLog as TradeLogModel;

interface TradeLogWriteRepositoryInterface
{
    public function store(TradeLog $trade_log): TradeLog;

    public function trash(TradeLogModel $trade_log): ?bool;

    public function restore(TradeLogModel $trade_log): ?bool;

    public function delete(TradeLogModel $trade_log): ?bool;
}
