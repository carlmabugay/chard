<?php

namespace App\Application\Portolio\UseCases;

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
