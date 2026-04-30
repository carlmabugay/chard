<?php

namespace App\Domain\CashFlow\Actions;

use App\Domain\CashFlow\Contracts\CashFlowRepositoryInterface;
use App\Domain\CashFlow\DTOs\DeleteCashFlowDTO;
use Closure;

final class DeleteCashFlowAction
{
    public function __construct(
        protected readonly CashFlowRepositoryInterface $repository,
    ) {}

    public function handle(DeleteCashFlowDTO $dto, Closure $next)
    {
        $this->repository->delete($dto);

        return $next($dto);
    }
}
