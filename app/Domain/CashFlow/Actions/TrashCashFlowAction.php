<?php

namespace App\Domain\CashFlow\Actions;

use App\Domain\CashFlow\Contracts\CashFlowRepositoryInterface;
use App\Domain\CashFlow\DTOs\TrashCashFlowDTO;
use Closure;

final class TrashCashFlowAction
{
    public function __construct(
        protected readonly CashFlowRepositoryInterface $repository,
    ) {}

    public function handle(TrashCashFlowDTO $dto, Closure $next)
    {
        $this->repository->trash($dto);

        return $next($dto);
    }
}
