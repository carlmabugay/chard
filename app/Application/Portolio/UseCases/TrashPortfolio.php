<?php

namespace App\Application\Portolio\UseCases;

use App\Domain\Portfolio\Services\PortfolioService;

class TrashPortfolio
{
    public function __construct(
        protected readonly PortfolioService $service,
    ) {}

    public function handle(int $id): ?bool
    {
        return $this->service->trash($id);
    }
}
