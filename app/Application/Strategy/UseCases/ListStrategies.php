<?php

namespace App\Application\Strategy\UseCases;

use App\Domain\Common\Query\QueryCriteria;
use App\Domain\Strategy\Contracts\ListStrategiesInterface;
use App\Domain\Strategy\Contracts\StrategyServiceInterface;

class ListStrategies implements ListStrategiesInterface
{
    public function __construct(
        private readonly StrategyServiceInterface $service
    ) {}

    public function handle(QueryCriteria $criteria): array
    {
        return $this->service->findAll($criteria);
    }
}
