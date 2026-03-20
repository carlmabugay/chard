<?php

namespace App\Application\Portolio\UseCases;

use App\Domain\Portfolio\Services\PortfolioService;

readonly class ListPortfolios
{
    public function __construct(
        private PortfolioService $service
    ) {}

    public function handle(): array
    {
        return $this->service->fetchAll();
    }
}
