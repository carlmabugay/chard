<?php

namespace App\Domain\Portfolio\Services;

use App\Domain\Common\Query\QueryCriteria;
use App\Domain\Portfolio\Contracts\Read\PortfolioReadRepositoryInterface;
use App\Domain\Portfolio\Contracts\Write\PortfolioWriteRepositoryInterface;
use App\Domain\Portfolio\Entities\Portfolio;

class PortfolioService
{
    public function __construct(
        private readonly PortfolioWriteRepositoryInterface $write_repository,
        private readonly PortfolioReadRepositoryInterface $read_repository
    ) {}

    public function findAll(QueryCriteria $criteria): array
    {
        return $this->read_repository->findAll($criteria);
    }

    public function findById(int $id): Portfolio
    {
        return $this->read_repository->findById($id);
    }

    public function store(Portfolio $portfolio): Portfolio
    {
        return $this->write_repository->store($portfolio);
    }

    public function trash(int $id): ?bool
    {
        return $this->write_repository->trash($id);
    }

    public function restore(int $id): ?bool
    {
        return $this->write_repository->restore($id);
    }

    public function delete(int $id): ?bool
    {
        return $this->write_repository->delete($id);
    }
}
