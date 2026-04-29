<?php

namespace App\Domain\CashFlow\Actions;

use App\Domain\CashFlow\Contracts\CashFlowRepositoryInterface;
use App\Domain\CashFlow\DTOs\ListCashFlowsDTO;
use Closure;

final class ListCashFlowAction
{
    public function __construct(
        protected readonly CashFlowRepositoryInterface $repository
    ) {}

    public function handle(ListCashFlowsDTO $dto, Closure $next)
    {
        $result = $this->repository->findAll($dto);

        return $next($result);
    }
}
