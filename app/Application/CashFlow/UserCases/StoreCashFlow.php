<?php

namespace App\Application\CashFlow\UserCases;

use App\Application\CashFlow\DTOs\StoreCashFlowDTO;
use App\Domain\CashFlow\Entities\CashFlow;
use App\Domain\CashFlow\Services\CashFlowService;

readonly class StoreCashFlow
{
    public function __construct(
        private CashFlowService $service
    ) {}

    public function handle(StoreCashFlowDTO $dto): CashFlow
    {
        $cash_flow = new CashFlow(
            portfolio_id: $dto->portfolioId(),
            type: $dto->type(),
            amount: $dto->amount(),
        );

        return $this->service->store($cash_flow);
    }
}
