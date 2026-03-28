<?php

namespace App\Application\Dividend\UseCases;

use App\Domain\Common\Query\QueryCriteria;
use App\Domain\Dividend\Services\DividendService;

class ListDividends
{
    public function __construct(private readonly DividendService $service) {}

    public function handle(QueryCriteria $criteria): array
    {
        return $this->service->findAll($criteria);
    }
}
