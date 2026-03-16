<?php

namespace App\Domain\Portfolio\Contracts\Read;

use App\Domain\Portfolio\Entities\Portfolio;

interface PortfolioReadRepositoryInterface
{
    public function fetchAll(): array;

    public function fetchById(int $id): Portfolio;
}
