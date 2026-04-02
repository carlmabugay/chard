<?php

namespace App\Domain\TradeLog\Contracts\Read;

use App\Domain\Common\Query\QueryCriteria;
use App\Domain\TradeLog\Entities\TradeLog;

interface TradeLogReadRepositoryInterface
{
    public function findAll(QueryCriteria $criteria): array;

    public function findById(int $id): TradeLog;
}
