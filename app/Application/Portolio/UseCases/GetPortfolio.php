<?php

namespace App\Application\Portolio\UseCases;

use App\Domain\Portfolio\Entities\Portfolio;
use App\Models\Portfolio as PortfolioModel;

class GetPortfolio
{
    public function handle(PortfolioModel $portfolio): Portfolio
    {
        return Portfolio::fromEloquentModel($portfolio);
    }
}
