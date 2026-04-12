<?php

namespace App\Application\Portolio\UseCases;

use App\Domain\Common\Query\QueryCriteria;
use App\Domain\Portfolio\Contracts\Services\PortfolioServiceInterface;
use App\Domain\Portfolio\Contracts\UseCases\ListPortfoliosInterface;

class ListPortfolios implements ListPortfoliosInterface
{
    public function __construct(
        private readonly PortfolioServiceInterface $service
    ) {}

    public function handle(QueryCriteria $criteria): array
    {
        return $this->service->findAll($criteria);
    }
}
