<?php

namespace App\Application\Portolio\UseCases;

use App\Application\Portolio\DTOs\PortfolioDTO;
use App\Domain\Portfolio\Contracts\Services\PortfolioServiceInterface;
use App\Domain\Portfolio\Contracts\UseCases\DeletePortfolioInterface;

class DeletePortfolio implements DeletePortfolioInterface
{
    public function __construct(
        protected readonly PortfolioServiceInterface $service
    ) {}

    public function handle(PortfolioDTO $dto): ?bool
    {
        return $this->service->delete($dto);
    }
}
