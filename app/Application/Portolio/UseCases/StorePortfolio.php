<?php

namespace App\Application\Portolio\UseCases;

use App\Application\Portolio\DTOs\PortfolioDTO;
use App\Domain\Portfolio\Contracts\Services\PortfolioServiceInterface;
use App\Domain\Portfolio\Contracts\UseCases\StorePortfolioInterface;
use App\Domain\Portfolio\Entities\Portfolio;

class StorePortfolio implements StorePortfolioInterface
{
    public function __construct(
        private readonly PortfolioServiceInterface $service
    ) {}

    public function handle(PortfolioDTO $dto): Portfolio
    {
        return $this->service->store($dto);
    }
}
