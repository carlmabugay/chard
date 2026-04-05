<?php

namespace App\Domain\Strategy\Services;

use App\Domain\Common\Query\QueryCriteria;
use App\Domain\Strategy\Contracts\Read\StrategyReadRepositoryInterface;
use App\Domain\Strategy\Contracts\Write\StrategyWriteRepositoryInterface;
use App\Domain\Strategy\Entities\Strategy;

class StrategyService
{
    public function __construct(
        private readonly StrategyWriteRepositoryInterface $write_repository,
        private readonly StrategyReadRepositoryInterface $read_repository,
    ) {}

    public function findAll(QueryCriteria $criteria): array
    {
        return $this->read_repository->findAll($criteria);
    }

    public function findById(int $id): Strategy
    {
        return $this->read_repository->findById($id);
    }

    public function store(Strategy $strategy): Strategy
    {
        return $this->write_repository->store($strategy);
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
