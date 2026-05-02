<?php

namespace App\Domain\TradeLog\Actions;

use App\Domain\TradeLog\Contracts\TradeLogRepositoryInterface;
use App\Domain\TradeLog\DTOs\TrashTradeLogDTO;
use Closure;

final class TrashTradeLogAction
{
    public function __construct(
        protected readonly TradeLogRepositoryInterface $repository,
    ) {}

    public function handle(TrashTradeLogDTO $dto, Closure $next)
    {
        $this->repository->trash($dto);

        return $next($dto);
    }
}
