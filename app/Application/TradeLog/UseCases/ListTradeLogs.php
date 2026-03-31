<?php

namespace App\Application\TradeLog\UseCases;

use App\Domain\Common\Query\QueryCriteria;
use App\Domain\TradeLog\Services\TradeLogService;

class ListTradeLogs
{
    public function __construct(
        private readonly TradeLogService $service
    ) {}

    public function handle(QueryCriteria $criteria): array
    {
        return $this->service->findAll($criteria);
    }
}
