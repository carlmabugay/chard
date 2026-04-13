<?php

namespace App\Domain\CashFlow\Contracts\Persistence\Write;

use App\Application\CashFlow\DTOs\CashFlowDTO;
use App\Domain\CashFlow\Entities\CashFlow;

interface CashFlowWriteRepositoryInterface
{
    public function store(CashFlowDTO $dto): CashFlow;

    public function trash(CashFlowDTO $dto): ?bool;

    public function restore(CashFlowDTO $dto): ?bool;

    public function delete(CashFlowDTO $dto): ?bool;
}
