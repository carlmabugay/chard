<?php

namespace App\Application\CashFlow\UserCases;

use App\Domain\CashFlow\Services\CashFlowService;
use App\Domain\Common\Query\QueryCriteria;

class ListCashFlows
{
    public function __construct(
        private readonly CashFlowService $service
    ) {}

    public function handle(QueryCriteria $criteria): array
    {
        return $this->service->findAll($criteria);
    }
}
