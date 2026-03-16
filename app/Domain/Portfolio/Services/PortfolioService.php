<?php

namespace App\Domain\Portfolio\Services;

use App\Domain\Portfolio\Contracts\Read\PortfolioReadRepositoryInterface;
use App\Domain\Portfolio\Contracts\Write\PortfolioWriteRepositoryInterface;
use App\Domain\Portfolio\Entities\Portfolio;

class PortfolioService
{
    public function __construct(
        private readonly PortfolioWriteRepositoryInterface $write_repository,
        private readonly PortfolioReadRepositoryInterface $read_repository
    ) {}

    public function fetchAll(): array
    {
        return $this->read_repository->fetchAll();
    }

    public function fetchById(int $id): Portfolio
    {
        return $this->read_repository->fetchById($id);
    }

    public function store(Portfolio $portfolio): Portfolio
    {
        return $this->write_repository->store($portfolio);
    }
}
