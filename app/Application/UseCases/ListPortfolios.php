<?php

namespace App\Application\UseCases;

use App\Domain\Portfolio\Services\PortfolioService;

class ListPortfolios
{
    public function __construct(
        private readonly PortfolioService $service
    ) {}

    public function handle(): array
    {
        return $this->service->fetchAll();
    }
}
