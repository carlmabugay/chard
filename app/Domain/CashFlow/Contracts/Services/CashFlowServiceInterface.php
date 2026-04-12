<?php

namespace App\Domain\CashFlow\Contracts\Services;

use App\Domain\CashFlow\Entities\CashFlow;
use App\Domain\Common\Query\QueryCriteria;
use App\Models\CashFlow as CashFlowModel;

interface CashFlowServiceInterface
{
    public function findAll(QueryCriteria $criteria): array;

    public function findById(int $id): CashFlow;

    public function store(CashFlow $cash_flow): CashFlow;

    public function trash(CashFlowModel $cash_flow): ?bool;

    public function restore(CashFlowModel $cash_flow): ?bool;

    public function delete(CashFlowModel $cash_flow): ?bool;
}
