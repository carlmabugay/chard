<?php

namespace App\Application\CashFlow\UserCases;

use App\Domain\CashFlow\Services\CashFlowService;

class ListCashFlows
{
    public function __construct(
        private readonly CashFlowService $service
    ) {}

    public function handle(): array
    {
        return $this->service->findAll();
    }
}
