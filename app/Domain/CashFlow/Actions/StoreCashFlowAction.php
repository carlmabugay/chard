<?php

namespace App\Domain\CashFlow\Actions;

use App\Domain\CashFlow\Contracts\CashFlowRepositoryInterface;
use App\Domain\CashFlow\DTOs\StoreCashFlowDTO;
use Closure;

final class StoreCashFlowAction
{
    public function __construct(
        protected readonly CashFlowRepositoryInterface $repository,
    ) {}

    public function handle(StoreCashFlowDTO $dto, Closure $next)
    {

        $this->repository->store($dto);

        return $next($dto);
    }
}
