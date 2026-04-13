<?php

namespace App\Domain\Portfolio\Services;

use App\Application\Portolio\DTOs\PortfolioDTO;
use App\Domain\Common\Query\QueryCriteria;
use App\Domain\Portfolio\Contracts\Persistence\Read\PortfolioReadRepositoryInterface;
use App\Domain\Portfolio\Contracts\Persistence\Write\PortfolioWriteRepositoryInterface;
use App\Domain\Portfolio\Contracts\Services\PortfolioServiceInterface;
use App\Domain\Portfolio\Entities\Portfolio;

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

    public function store(PortfolioDTO $dto): Portfolio
    {
        return $this->write_repository->store($dto);
    }

    public function trash(PortfolioDTO $dto): ?bool
    {
        return $this->write_repository->trash($dto);
    }

    public function restore(PortfolioDTO $dto): ?bool
    {
        return $this->write_repository->restore($dto);
    }

    public function delete(PortfolioDTO $dto): ?bool
    {
        return $this->write_repository->delete($dto);
    }
}
