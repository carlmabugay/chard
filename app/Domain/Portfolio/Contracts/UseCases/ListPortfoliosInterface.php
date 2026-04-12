<?php

namespace App\Domain\Portfolio\Contracts\UseCases;

use App\Domain\Common\Query\QueryCriteria;

interface ListPortfoliosInterface
{
    public function handle(QueryCriteria $criteria): array;
}
