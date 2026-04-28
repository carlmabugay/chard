<?php

namespace App\Domain\Portfolio\Contracts\Persistence\Read;

use App\Domain\Portfolio\Entities\Portfolio;

interface PortfolioReadRepositoryInterface
{
    public function findById(int $id): Portfolio;
}
