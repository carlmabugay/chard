<?php

namespace App\Domain\TradeLog\Contracts\Read;

use App\Domain\Common\Query\QueryCriteria;

interface TradeLogReadRepositoryInterface
{
    public function findAll(QueryCriteria $criteria): array;
}
