<?php

namespace App\Domain\Portfolio\Contracts;

use App\Domain\Portfolio\DTOs\ListPortfoliosDTO;
use Illuminate\Pagination\LengthAwarePaginator;

interface PortfolioRepositoryInterface
{
    public function findAll(ListPortfoliosDTO $dto): LengthAwarePaginator;
}
