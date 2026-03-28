<?php

namespace App\Application\Strategy\UseCases;

use App\Domain\Common\Query\QueryCriteria;
use App\Domain\Strategy\Services\StrategyService;

class ListStrategies
{
    public function __construct(
        private readonly StrategyService $service
    ) {}

    public function handle(QueryCriteria $criteria): array
    {
        return $this->service->fetchAll($criteria);
    }
}
