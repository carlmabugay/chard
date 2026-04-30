<?php

namespace App\Domain\CashFlow\Contracts;

use App\Domain\CashFlow\DTOs\ListCashFlowsDTO;
use App\Domain\CashFlow\DTOs\RestoreCashFlowDTO;
use App\Domain\CashFlow\DTOs\StoreCashFlowDTO;
use App\Domain\CashFlow\DTOs\TrashCashFlowDTO;
use App\Domain\CashFlow\DTOs\UpdateCashFlowDTO;
use Illuminate\Pagination\LengthAwarePaginator;

interface CashFlowRepositoryInterface
{
    public function findAll(ListCashFlowsDTO $dto): LengthAwarePaginator;

    public function store(StoreCashFlowDTO $dto): void;

    public function update(UpdateCashFlowDTO $dto): void;

    public function trash(TrashCashFlowDTO $dto): void;

    public function restore(RestoreCashFlowDTO $dto): void;
}
