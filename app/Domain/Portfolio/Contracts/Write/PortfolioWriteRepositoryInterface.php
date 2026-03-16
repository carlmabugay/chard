<?php

namespace App\Domain\Portfolio\Contracts\Write;

use App\Domain\Portfolio\Entities\Portfolio;

interface PortfolioWriteRepositoryInterface
{
    public function store(Portfolio $portfolio): Portfolio;
}
