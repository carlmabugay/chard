<?php

namespace App\Domain\Portfolio\Contracts\UseCases;

use App\Models\Portfolio as PortfolioModel;

interface RestorePortfolioInterface
{
    public function handle(PortfolioModel $portfolio): ?bool;
}
