<?php

namespace App\Application\CashFlow\UserCases;

use App\Application\CashFlow\DTOs\CashFlowDTO;
use App\Domain\CashFlow\Contracts\Services\CashFlowServiceInterface;
use App\Domain\CashFlow\Contracts\UseCases\TrashCashFlowInterface;

class TrashCashFlow implements TrashCashFlowInterface
{
    public function __construct(
        protected readonly CashFlowServiceInterface $service
    ) {}

    public function handle(CashFlowDTO $dto): ?bool
    {
        return $this->service->trash($dto);
    }
}
