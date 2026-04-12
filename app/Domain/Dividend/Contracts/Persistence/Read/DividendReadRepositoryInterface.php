<?php

namespace App\Domain\Dividend\Contracts\Persistence\Read;

use App\Domain\Common\Query\QueryCriteria;
use App\Domain\Dividend\Entities\Dividend;

interface DividendReadRepositoryInterface
{
    public function findAll(QueryCriteria $criteria): array;

    public function findById(int $id): Dividend;
}
