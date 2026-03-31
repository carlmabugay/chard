<?php

namespace App\Domain\TradeLog\Services;

use App\Domain\Common\Query\QueryCriteria;
use App\Domain\TradeLog\Contracts\Read\TradeLogReadRepositoryInterface;

class TradeLogService
{
    public function __construct(
        private readonly TradeLogReadRepositoryInterface $read_repository,
    ) {}

    public function findAll(QueryCriteria $criteria): array
    {
        return $this->read_repository->findAll($criteria);
    }
}
