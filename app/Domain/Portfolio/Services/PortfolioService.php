<?php

namespace App\Domain\Portfolio\Services;

use App\Domain\Portfolio\Contracts\Read\PortfolioReadRepositoryInterface;
use App\Domain\Portfolio\Entities\Portfolio;

class PortfolioService
{
    public function __construct(
        private readonly PortfolioReadRepositoryInterface $repository
    ) {}

    public function fetchAll(): array
    {
        return $this->repository->fetchAll();
    }

    public function fetchById(int $id): Portfolio
    {
        return $this->repository->fetchById($id);
    }
}
