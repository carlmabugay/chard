<?php

namespace App\Application\Portolio\UseCases;

use App\Domain\Portfolio\Contracts\UseCases\GetPortfolioInterface;
use App\Domain\Portfolio\Entities\Portfolio;
use App\Models\Portfolio as PortfolioModel;

class GetPortfolio implements GetPortfolioInterface
{
    public function handle(PortfolioModel $portfolio): Portfolio
    {
        return Portfolio::fromEloquentModel($portfolio);
    }
}
