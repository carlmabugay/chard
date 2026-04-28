<?php

namespace App\Domain\Portfolio\Services;

use App\Domain\Portfolio\Contracts\Persistence\Read\PortfolioReadRepositoryInterface;
use App\Domain\Portfolio\Contracts\Services\PortfolioServiceInterface;
use App\Domain\Portfolio\Entities\Portfolio;

class PortfolioService implements PortfolioServiceInterface
{
    public function __construct(
        private readonly PortfolioReadRepositoryInterface $read_repository
    ) {}

    public function findById(int $id): Portfolio
    {
        return $this->read_repository->findById($id);
    }
}
