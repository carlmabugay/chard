<?php

namespace App\Domain\CashFlow\Services;

use App\Domain\CashFlow\Contracts\Persistence\Read\CashFlowReadRepositoryInterface;
use App\Domain\CashFlow\Contracts\Persistence\Write\CashFlowWriteRepositoryInterface;
use App\Domain\CashFlow\Contracts\Services\CashFlowServiceInterface;
use App\Domain\CashFlow\Entities\CashFlow;
use App\Domain\Common\Query\QueryCriteria;
use App\Models\CashFlow as CashFlowModel;

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

    public function store(CashFlow $cash_flow): CashFlow
    {
        return $this->write_repository->store($cash_flow);
    }

    public function trash(CashFlowModel $cash_flow): ?bool
    {
        return $this->write_repository->trash($cash_flow);
    }

    public function restore(CashFlowModel $cash_flow): ?bool
    {
        return $this->write_repository->restore($cash_flow);
    }

    public function delete(CashFlowModel $cash_flow): ?bool
    {
        return $this->write_repository->delete($cash_flow);
    }
}
