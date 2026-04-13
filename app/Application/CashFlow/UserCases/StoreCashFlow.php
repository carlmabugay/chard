<?php

namespace App\Application\CashFlow\UserCases;

use App\Application\CashFlow\DTOs\CashFlowDTO;
use App\Domain\CashFlow\Contracts\Services\CashFlowServiceInterface;
use App\Domain\CashFlow\Contracts\UseCases\StoreCashFlowInterface;
use App\Domain\CashFlow\Entities\CashFlow;

class StoreCashFlow implements StoreCashFlowInterface
{
    public function __construct(
        private readonly CashFlowServiceInterface $service
    ) {}

    public function handle(CashFlowDTO $dto): CashFlow
    {
        return $this->service->store($dto);
    }
}
