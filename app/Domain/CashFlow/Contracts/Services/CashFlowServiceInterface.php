<?php

namespace App\Domain\CashFlow\Contracts\Services;

use App\Application\CashFlow\DTOs\CashFlowDTO;
use App\Domain\CashFlow\Entities\CashFlow;
use App\Domain\Common\Query\QueryCriteria;

interface CashFlowServiceInterface
{
    public function findAll(QueryCriteria $criteria): array;

    public function findById(int $id): CashFlow;

    public function store(CashFlowDTO $dto): CashFlow;

    public function trash(CashFlowDTO $dto): ?bool;

    public function restore(CashFlowDTO $dto): ?bool;

    public function delete(CashFlowDTO $dto): ?bool;
}
