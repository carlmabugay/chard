<?php

namespace App\Domain\CashFlow\Contracts\Persistence\Read;

use App\Domain\CashFlow\Entities\CashFlow;
use App\Domain\Common\Query\QueryCriteria;

interface CashFlowReadRepositoryInterface
{
    public function findAll(QueryCriteria $criteria): array;

    public function findById(int $id): CashFlow;
}
