<?php

namespace App\Application\CashFlow\UserCases;

use App\Application\CashFlow\DTOs\StoreCashFlowDTO;
use App\Domain\CashFlow\Entities\CashFlow;
use App\Domain\CashFlow\Services\CashFlowService;

class StoreCashFlow
{
    public function __construct(
        private readonly CashFlowService $service
    ) {}

    public function handle(StoreCashFlowDTO $dto): CashFlow
    {
        $cash_flow = CashFlow::fromDTO($dto);

        return $this->service->store($cash_flow);
    }
}
