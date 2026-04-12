<?php

namespace App\Application\Strategy\UseCases;

use App\Domain\Common\Query\QueryCriteria;
use App\Domain\Strategy\Contracts\Services\StrategyServiceInterface;
use App\Domain\Strategy\Contracts\UseCases\ListStrategiesInterface;

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
