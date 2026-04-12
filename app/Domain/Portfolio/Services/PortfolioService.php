<?php

namespace App\Domain\Portfolio\Services;

use App\Domain\Common\Query\QueryCriteria;
use App\Domain\Portfolio\Contracts\Persistence\Read\PortfolioReadRepositoryInterface;
use App\Domain\Portfolio\Contracts\Persistence\Write\PortfolioWriteRepositoryInterface;
use App\Domain\Portfolio\Contracts\Services\PortfolioServiceInterface;
use App\Domain\Portfolio\Entities\Portfolio;
use App\Models\Portfolio as PortfolioModel;

class PortfolioService implements PortfolioServiceInterface
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

    public function trash(PortfolioModel $portfolio): ?bool
    {
        return $this->write_repository->trash($portfolio);
    }

    public function restore(PortfolioModel $portfolio): ?bool
    {
        return $this->write_repository->restore($portfolio);
    }

    public function delete(PortfolioModel $portfolio): ?bool
    {
        return $this->write_repository->delete($portfolio);
    }
}
