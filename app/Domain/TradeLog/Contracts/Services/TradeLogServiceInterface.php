<?php

namespace App\Domain\TradeLog\Contracts\Services;

use App\Domain\Common\Query\QueryCriteria;
use App\Domain\TradeLog\Entities\TradeLog;
use App\Models\TradeLog as TradeLogModel;

interface TradeLogServiceInterface
{
    public function findAll(QueryCriteria $criteria): array;

    public function findById(int $id): TradeLog;

    public function store(TradeLog $tradeLog): TradeLog;

    public function trash(TradeLogModel $trade_log): ?bool;

    public function restore(TradeLogModel $trade_log): ?bool;

    public function delete(TradeLogModel $trade_log): ?bool;
}
