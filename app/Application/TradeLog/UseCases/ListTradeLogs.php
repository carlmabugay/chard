<?php

namespace App\Application\TradeLog\UseCases;

use App\Domain\Common\Query\QueryCriteria;
use App\Domain\TradeLog\Contracts\Services\TradeLogServiceInterface;
use App\Domain\TradeLog\Contracts\UseCases\ListTradeLogsInterface;

class ListTradeLogs implements ListTradeLogsInterface
{
    public function __construct(
        private readonly TradeLogServiceInterface $service
    ) {}

    public function handle(QueryCriteria $criteria): array
    {
        return $this->service->findAll($criteria);
    }
}
