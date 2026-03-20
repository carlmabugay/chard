<?php

namespace App\Domain\CashFlow\Services;

use App\Domain\CashFlow\Contracts\Read\CashFlowReadRepositoryInterface;
use App\Domain\CashFlow\Contracts\Write\CashFlowWriteRepositoryInterface;
use App\Domain\CashFlow\Entities\CashFlow;

class CashFlowService
{
    public function __construct(
        private readonly CashFlowWriteRepositoryInterface $write_repository,
        private readonly CashFlowReadRepositoryInterface $read_repository,
    ) {}

    public function findAll(): array
    {
        return $this->read_repository->findAll();
    }

    public function findById(int $id): CashFlow
    {
        return $this->read_repository->findById($id);
    }

    public function store(CashFlow $cash_flow): CashFlow
    {
        return $this->write_repository->store($cash_flow);
    }
}
