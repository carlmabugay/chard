<?php

namespace App\Domain\Portfolio\Contracts\UseCases;

use App\Domain\Portfolio\Entities\Portfolio;
use App\Models\Portfolio as PortfolioModel;

interface GetPortfolioInterface
{
    public function handle(PortfolioModel $portfolio): Portfolio;
}
