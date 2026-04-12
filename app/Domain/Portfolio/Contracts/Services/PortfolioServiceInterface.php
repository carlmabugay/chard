<?php

namespace App\Domain\Portfolio\Contracts\Services;

use App\Domain\Common\Query\QueryCriteria;
use App\Domain\Portfolio\Entities\Portfolio;
use App\Models\Portfolio as PortfolioModel;

interface PortfolioServiceInterface
{
    public function findAll(QueryCriteria $criteria): array;

    public function findById(int $id): Portfolio;

    public function store(Portfolio $portfolio): Portfolio;

    public function trash(PortfolioModel $portfolio): ?bool;

    public function restore(PortfolioModel $portfolio): ?bool;

    public function delete(PortfolioModel $portfolio): ?bool;
}
