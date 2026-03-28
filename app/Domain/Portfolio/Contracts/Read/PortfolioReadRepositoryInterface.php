<?php

namespace App\Domain\Portfolio\Contracts\Read;

use App\Domain\Common\Query\QueryCriteria;
use App\Domain\Portfolio\Entities\Portfolio;

interface PortfolioReadRepositoryInterface
{
    public function fetchAll(QueryCriteria $criteria): array;

    public function fetchById(int $id): Portfolio;
}
