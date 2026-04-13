<?php

namespace App\Domain\CashFlow\Services;

use App\Application\CashFlow\DTOs\CashFlowDTO;
use App\Domain\CashFlow\Contracts\Persistence\Read\CashFlowReadRepositoryInterface;
use App\Domain\CashFlow\Contracts\Persistence\Write\CashFlowWriteRepositoryInterface;
use App\Domain\CashFlow\Contracts\Services\CashFlowServiceInterface;
use App\Domain\CashFlow\Entities\CashFlow;
use App\Domain\Common\Query\QueryCriteria;

class CashFlowService implements CashFlowServiceInterface
{
    public function __construct(
        private readonly CashFlowWriteRepositoryInterface $write_repository,
        private readonly CashFlowReadRepositoryInterface $read_repository,
    ) {}

    public function findAll(QueryCriteria $criteria): array
    {
        return $this->read_repository->findAll($criteria);
    }

    /*
     * @throws ModelNotFoundException
     */
    public function findById(int $id): CashFlow
    {
        return $this->read_repository->findById($id);
    }

    public function store(CashFlowDTO $dto): CashFlow
    {
        return $this->write_repository->store($dto);
    }

    public function trash(CashFlowDTO $dto): ?bool
    {
        return $this->write_repository->trash($dto);
    }

    public function restore(CashFlowDTO $dto): ?bool
    {
        return $this->write_repository->restore($dto);
    }

    public function delete(CashFlowDTO $dto): ?bool
    {
        return $this->write_repository->delete($dto);
    }
}
