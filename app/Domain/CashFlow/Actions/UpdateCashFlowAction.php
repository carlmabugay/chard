<?php

namespace App\Domain\CashFlow\Actions;

use App\Domain\CashFlow\Contracts\CashFlowRepositoryInterface;
use App\Domain\CashFlow\DTOs\UpdateCashFlowDTO;
use Closure;

final class UpdateCashFlowAction
{
    public function __construct(
        protected readonly CashFlowRepositoryInterface $repository,
    ) {}

    public function handle(UpdateCashFlowDTO $dto, Closure $next)
    {

        $this->repository->update($dto);

        return $next($dto);
    }
}
