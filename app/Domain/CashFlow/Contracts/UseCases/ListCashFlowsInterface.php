<?php

namespace App\Domain\CashFlow\Contracts\UseCases;

use App\Domain\Common\Query\QueryCriteria;

interface ListCashFlowsInterface
{
    public function handle(QueryCriteria $criteria): array;
}
