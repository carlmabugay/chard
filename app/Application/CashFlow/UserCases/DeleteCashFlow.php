<?php

namespace App\Application\CashFlow\UserCases;

use App\Application\CashFlow\DTOs\CashFlowDTO;
use App\Domain\CashFlow\Contracts\Services\CashFlowServiceInterface;
use App\Domain\CashFlow\Contracts\UseCases\DeleteCashFlowInterface;

class DeleteCashFlow implements DeleteCashFlowInterface
{
    public function __construct(
        protected CashFlowServiceInterface $service
    ) {}

    public function handle(CashFlowDTO $dto): ?bool
    {
        return $this->service->delete($dto);
    }
}
