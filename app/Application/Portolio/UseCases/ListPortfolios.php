<?php

namespace App\Application\Portolio\UseCases;

use App\Domain\Common\Query\QueryCriteria;
use App\Domain\Portfolio\Services\PortfolioService;

class ListPortfolios
{
    public function __construct(
        private readonly PortfolioService $service
    ) {}

    public function handle(QueryCriteria $criteria): array
    {
        return $this->service->findAll($criteria);
    }
}
