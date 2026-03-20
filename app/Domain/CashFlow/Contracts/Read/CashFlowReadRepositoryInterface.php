<?php

namespace App\Domain\CashFlow\Contracts\Read;

interface CashFlowReadRepositoryInterface
{
    public function findAll(): array;
}
