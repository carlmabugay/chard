<?php

namespace App\Domain\CashFlow\Contracts;

use App\Domain\CashFlow\DTOs\ListCashFlowsDTO;
use Illuminate\Pagination\LengthAwarePaginator;

interface CashFlowRepositoryInterface
{
    public function findAll(ListCashFlowsDTO $dto): LengthAwarePaginator;
}
