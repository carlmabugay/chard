<?php

namespace App\Domain\Strategy\Services;

use App\Application\Strategy\DTOs\StrategyDTO;
use App\Domain\Common\Query\QueryCriteria;
use App\Domain\Strategy\Contracts\Persistence\Read\StrategyReadRepositoryInterface;
use App\Domain\Strategy\Contracts\Persistence\Write\StrategyWriteRepositoryInterface;
use App\Domain\Strategy\Contracts\Services\StrategyServiceInterface;
use App\Domain\Strategy\Entities\Strategy;

class StrategyService implements StrategyServiceInterface
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

    public function store(StrategyDTO $dto): Strategy
    {
        return $this->write_repository->store($dto);
    }

    public function trash(StrategyDTO $dto): ?bool
    {
        return $this->write_repository->trash($dto);
    }

    public function restore(StrategyDTO $dto): ?bool
    {
        return $this->write_repository->restore($dto);
    }

    public function delete(StrategyDTO $dto): ?bool
    {
        return $this->write_repository->delete($dto);
    }
}
