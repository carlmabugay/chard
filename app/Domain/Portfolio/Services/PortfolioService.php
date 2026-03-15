<?php

namespace App\Domain\Portfolio\Services;

use App\Domain\Portfolio\Contracts\Read\PortfolioReadRepositoryInterface;

class PortfolioService
{
    public function __construct(
        private PortfolioReadRepositoryInterface $repository
    ) {}

    public function fetchAll(): array
    {
        return $this->repository->fetchAll();
    }
}
