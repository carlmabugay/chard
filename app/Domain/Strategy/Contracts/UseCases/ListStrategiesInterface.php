<?php

namespace App\Domain\Strategy\Contracts\UseCases;

use App\Domain\Common\Query\QueryCriteria;

interface ListStrategiesInterface
{
    public function handle(QueryCriteria $criteria): array;
}
