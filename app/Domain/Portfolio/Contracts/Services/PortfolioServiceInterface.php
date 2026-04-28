<?php

namespace App\Domain\Portfolio\Contracts\Services;

use App\Domain\Portfolio\Entities\Portfolio;

interface PortfolioServiceInterface
{
    public function findById(int $id): Portfolio;
}
