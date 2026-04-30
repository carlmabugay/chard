<?php

namespace App\Domain\CashFlow\Actions;

use App\Domain\CashFlow\Contracts\CashFlowRepositoryInterface;
use App\Domain\CashFlow\DTOs\RestoreCashFlowDTO;
use Closure;

final class RestoreCashFlowAction
{
    public function __construct(
        protected readonly CashFlowRepositoryInterface $repository,
    ) {}

    public function handle(RestoreCashFlowDTO $dto, Closure $next)
    {
        $this->repository->restore($dto);

        return $next($dto);
    }
}
