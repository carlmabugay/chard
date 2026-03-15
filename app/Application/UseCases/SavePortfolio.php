<?php

namespace App\Application\UseCases;

use App\Application\DTOs\SavePortfolioDTO;
use App\Domain\Portfolio\Entities\Portfolio;
use App\Domain\Portfolio\Services\PortfolioService;

class SavePortfolio
{
    public function __construct(
        private readonly PortfolioService $service
    ) {}

    public function handle(SavePortfolioDTO $dto): void
    {
        $portfolio = new Portfolio(
            user_id: $dto->user_id,
            name: $dto->name,
        );

        $this->service->save($portfolio);
    }
}
