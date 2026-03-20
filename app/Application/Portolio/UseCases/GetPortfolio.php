<?php

namespace App\Application\Portolio\UseCases;

use App\Domain\Portfolio\Entities\Portfolio;
use App\Domain\Portfolio\Services\PortfolioService;

readonly class GetPortfolio
{
    public function __construct(
        private PortfolioService $service
    ) {}

    public function handle(int $id): Portfolio
    {
        return $this->service->fetchById($id);
    }
}
