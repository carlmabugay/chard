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
        $portfolio = new Portfolio(
            user_id: $dto->userId(),
            name: $dto->name(),
            id: $dto->id(),
        );

        return $this->service->store($portfolio);
    }
}
