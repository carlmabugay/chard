<?php

namespace App\Domain\Strategy\Contracts;

use App\Domain\Common\Query\QueryCriteria;

interface ListStrategiesInterface
{
    public function handle(QueryCriteria $criteria): array;
}
