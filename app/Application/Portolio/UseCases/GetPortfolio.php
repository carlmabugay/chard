<?php

namespace App\Application\Portolio\UseCases;

use App\Domain\Portfolio\Entities\Portfolio;
use App\Domain\Portfolio\Services\PortfolioService;

class GetPortfolio
{
    public function __construct(
        private readonly PortfolioService $service
    ) {}

    public function handle(int $id): Portfolio
    {
        return $this->service->findById($id);
    }
}
