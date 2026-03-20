<?php

namespace App\Domain\CashFlow\Services;

use App\Domain\CashFlow\Entities\CashFlow;
use App\Infrastructure\Persistence\Eloquent\Read\EloquentCashFlowReadRepository;

class CashFlowService
{
    public function __construct(
        private readonly EloquentCashFlowReadRepository $read_repository,
    ) {}

    public function findAll(): array
    {
        return $this->read_repository->findAll();
    }

    public function findById(int $id): CashFlow
    {
        return $this->read_repository->findById($id);
    }
}
