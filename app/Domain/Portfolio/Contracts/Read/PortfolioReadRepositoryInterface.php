<?php

namespace App\Domain\Portfolio\Contracts\Read;

use App\Domain\Portfolio\Entities\Portfolio;
use App\Models\Portfolio as PortfolioModel;

interface PortfolioReadRepositoryInterface
{
    public function fetchAll(): array;

    public function toDomain(PortfolioModel $portfolio): Portfolio;
}
