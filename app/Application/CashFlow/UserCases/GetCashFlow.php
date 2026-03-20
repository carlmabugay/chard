<?php

namespace App\Application\CashFlow\UserCases;

use App\Domain\CashFlow\Entities\CashFlow;
use App\Domain\CashFlow\Services\CashFlowService;

readonly class GetCashFlow
{
    public function __construct(
        private CashFlowService $service
    ) {}

    public function handle(int $id): CashFlow
    {
        return $this->service->findById($id);
    }
}
