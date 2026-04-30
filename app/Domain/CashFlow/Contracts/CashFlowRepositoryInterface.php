<?php

namespace App\Domain\CashFlow\Contracts;

use App\Domain\CashFlow\DTOs\ListCashFlowsDTO;
use App\Domain\CashFlow\DTOs\StoreCashFlowDTO;
use Illuminate\Pagination\LengthAwarePaginator;

interface CashFlowRepositoryInterface
{
    public function findAll(ListCashFlowsDTO $dto): LengthAwarePaginator;

    public function store(StoreCashFlowDTO $dto): void;
}
