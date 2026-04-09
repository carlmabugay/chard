<?php

namespace App\Application\Portolio\UseCases;

use App\Domain\Portfolio\Services\PortfolioService;
use App\Models\Portfolio as PortfolioModel;

class TrashPortfolio
{
    public function __construct(
        protected readonly PortfolioService $service,
    ) {}

    public function handle(PortfolioModel $portfolio): ?bool
    {
        return $this->service->trash($portfolio);
    }
}
