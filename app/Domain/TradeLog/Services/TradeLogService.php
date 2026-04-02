<?php

namespace App\Domain\TradeLog\Services;

use App\Domain\Common\Query\QueryCriteria;
use App\Domain\TradeLog\Contracts\Read\TradeLogReadRepositoryInterface;
use App\Domain\TradeLog\Entities\TradeLog;

class TradeLogService
{
    public function __construct(
        private readonly TradeLogReadRepositoryInterface $read_repository,
    ) {}

    public function findAll(QueryCriteria $criteria): array
    {
        return $this->read_repository->findAll($criteria);
    }

    public function findById(int $id): TradeLog
    {
        return $this->read_repository->findById($id);
    }
}
