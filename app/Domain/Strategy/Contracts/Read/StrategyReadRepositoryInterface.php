<?php

namespace App\Domain\Strategy\Contracts\Read;

use App\Domain\Common\Query\QueryCriteria;
use App\Domain\Strategy\Entities\Strategy;

interface StrategyReadRepositoryInterface
{
    public function fetchAll(QueryCriteria $criteria): array;

    public function fetchById(int $id): Strategy;
}
