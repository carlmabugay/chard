<?php

namespace App\Application\Dividend\UseCases;

use App\Domain\Common\Query\QueryCriteria;
use App\Domain\Dividend\Contracts\Services\DividendServiceInterface;
use App\Domain\Dividend\Contracts\UseCases\ListDividendsInterface;

class ListDividends implements ListDividendsInterface
{
    public function __construct(
        private readonly DividendServiceInterface $service
    ) {}

    public function handle(QueryCriteria $criteria): array
    {
        return $this->service->findAll($criteria);
    }
}
