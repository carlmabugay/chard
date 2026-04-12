<?php

namespace App\Domain\Dividend\Contracts\UseCases;

use App\Domain\Common\Query\QueryCriteria;

interface ListDividendsInterface
{
    public function handle(QueryCriteria $criteria): array;
}
