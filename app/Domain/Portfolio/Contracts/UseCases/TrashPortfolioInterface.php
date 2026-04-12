<?php

namespace App\Domain\Portfolio\Contracts\UseCases;

use App\Models\Portfolio as PortfolioModel;

interface TrashPortfolioInterface
{
    public function handle(PortfolioModel $portfolio): ?bool;
}
