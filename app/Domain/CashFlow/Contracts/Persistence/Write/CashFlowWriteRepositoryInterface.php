<?php

namespace App\Domain\CashFlow\Contracts\Persistence\Write;

use App\Domain\CashFlow\Entities\CashFlow;
use App\Models\CashFlow as CashFlowModel;

interface CashFlowWriteRepositoryInterface
{
    public function store(CashFlow $cash_flow): CashFlow;

    public function trash(CashFlowModel $cash_flow): ?bool;

    public function restore(CashFlowModel $cash_flow): ?bool;

    public function delete(CashFlowModel $cash_flow): ?bool;
}
