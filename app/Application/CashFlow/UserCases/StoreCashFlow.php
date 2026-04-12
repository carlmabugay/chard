<?php

namespace App\Application\CashFlow\UserCases;

use App\Application\CashFlow\DTOs\StoreCashFlowDTO;
use App\Domain\CashFlow\Contracts\Services\CashFlowServiceInterface;
use App\Domain\CashFlow\Contracts\UseCases\StoreCashFlowInterface;
use App\Domain\CashFlow\Entities\CashFlow;

class StoreCashFlow implements StoreCashFlowInterface
{
    public function __construct(
        private readonly CashFlowServiceInterface $service
    ) {}

    public function handle(StoreCashFlowDTO $dto): CashFlow
    {
        $cash_flow = CashFlow::fromDTO($dto);

        return $this->service->store($cash_flow);
    }
}
