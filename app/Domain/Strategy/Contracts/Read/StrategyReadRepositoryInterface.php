<?php

namespace App\Domain\Strategy\Contracts\Read;

use App\Domain\Common\Query\QueryCriteria;
use App\Domain\Strategy\Entities\Strategy;

interface StrategyReadRepositoryInterface
{
    public function findAll(QueryCriteria $criteria): array;

    public function findById(int $id): Strategy;
}
