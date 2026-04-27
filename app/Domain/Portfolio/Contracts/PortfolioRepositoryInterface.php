<?php

namespace App\Domain\Portfolio\Contracts;

use App\Domain\Portfolio\DTOs\ListPortfoliosDTO;
use App\Domain\Portfolio\DTOs\StorePortfolioDTO;
use Illuminate\Pagination\LengthAwarePaginator;

interface PortfolioRepositoryInterface
{
    public function findAll(ListPortfoliosDTO $dto): LengthAwarePaginator;

    public function store(StorePortfolioDTO $dto): void;
}
