<?php

namespace App\Application\CashFlow\UserCases;

use App\Domain\CashFlow\Services\CashFlowService;

class RestoreCashFlow
{
    public function __construct(
        protected CashFlowService $service,
    ) {}

    public function handle(int $id): ?bool
    {
        return $this->service->restore($id);
    }
}
