<?php

namespace App\Domain\Portfolio\Contracts\Services;

use App\Application\Portolio\DTOs\PortfolioDTO;
use App\Domain\Common\Query\QueryCriteria;
use App\Domain\Portfolio\Entities\Portfolio;

interface PortfolioServiceInterface
{
    public function findAll(QueryCriteria $criteria): array;

    public function findById(int $id): Portfolio;

    public function store(PortfolioDTO $dto): Portfolio;

    public function trash(PortfolioDTO $dto): ?bool;

    public function restore(PortfolioDTO $dto): ?bool;

    public function delete(PortfolioDTO $dto): ?bool;
}
