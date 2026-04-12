<?php

namespace App\Application\Portolio\UseCases;

use App\Domain\Portfolio\Contracts\Services\PortfolioServiceInterface;
use App\Domain\Portfolio\Contracts\UseCases\DeletePortfolioInterface;
use App\Models\Portfolio as PortfolioModel;

class DeletePortfolio implements DeletePortfolioInterface
{
    public function __construct(
        protected readonly PortfolioServiceInterface $service
    ) {}

    public function handle(PortfolioModel $portfolio): ?bool
    {
        return $this->service->delete($portfolio);
    }
}
