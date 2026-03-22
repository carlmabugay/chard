<?php

namespace App\Application\Portolio\UseCases;

use App\Application\Portolio\DTOs\StorePortfolioDTO;
use App\Domain\Portfolio\Entities\Portfolio;
use App\Domain\Portfolio\Services\PortfolioService;

class StorePortfolio
{
    public function __construct(
        private readonly PortfolioService $service
    ) {}

    public function handle(StorePortfolioDTO $dto): Portfolio
    {
        $portfolio = Portfolio::fromDTO($dto);

        return $this->service->store($portfolio);
    }
}
