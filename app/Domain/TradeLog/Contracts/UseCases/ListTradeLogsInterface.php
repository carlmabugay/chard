<?php

namespace App\Domain\TradeLog\Contracts\UseCases;

use App\Domain\Common\Query\QueryCriteria;

interface ListTradeLogsInterface
{
    public function handle(QueryCriteria $criteria): array;
}
