<?php

namespace App\Application\CashFlow\UserCases;

use App\Domain\CashFlow\Contracts\Services\CashFlowServiceInterface;
use App\Domain\CashFlow\Contracts\UseCases\ListCashFlowsInterface;
use App\Domain\Common\Query\QueryCriteria;

class ListCashFlows implements ListCashFlowsInterface
{
    public function __construct(
        private readonly CashFlowServiceInterface $service
    ) {}

    public function handle(QueryCriteria $criteria): array
    {
        return $this->service->findAll($criteria);
    }
}
